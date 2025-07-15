<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierOrder;
use App\Mail\PedidoReposicaoMail;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        \DB::listen(function ($query) {
            \Log::info('SQL Executada:', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time
            ]);
        });

        $query = Product::select(['id', 'description', 'barcode', 'supplierId', 'value', 'image_url'])
            ->with('supplier')
            ->orderBy('id', 'desc');

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('description', 'like', "%$q%")
                    ->orWhere('code', 'like', "%$q%")
                    ->orWhere('barcode', 'like', "%$q%");
            });
        }

        // Cache para listagem sem filtro
        if (!$request->has('q') || !$request->q) {
            $products = \Cache::remember('products_page_' . $request->get('page', 1), 60, function () use ($query) {
                return $query->paginate(10);
            });
        } else {
            $products = $query->paginate(10);
        }

        if ($request->ajax()) {
            return response()->json([
                'data' => $products->items(),
                'total' => $products->total(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]);
        }

        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('cadastro-produto', compact('product', 'suppliers'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        // Limpa o cache das páginas de produtos
        foreach (range(1, 10) as $page) {
            \Cache::forget('products_page_' . $page);
        }
        return redirect('/lista-produtos')->with('success', 'Produto excluído com sucesso!');
    }

    public function update(Request $request, $id)
    {
        try {
            \Log::info('Dados recebidos para update:', $request->all());
            
            $product = Product::findOrFail($id);
            \Log::info('Produto encontrado:', $product->toArray());

            $validated = $request->validate([
                'description' => 'required|string|max:255',
                'barcode' => 'required|string|max:50',
                'code' => 'nullable|string|max:255',
                'expiration_date' => 'nullable|date',
                'value' => 'nullable|numeric',
                'profit' => 'nullable|numeric',
                'supplierId' => 'nullable|exists:suppliers,id',
                'brand' => 'nullable|string|max:100',
                'model' => 'nullable|string|max:100',
                'currentStock' => 'nullable|integer',
                'minimumStock' => 'nullable|integer',
                'status' => 'nullable|boolean',
                'image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            \Log::info('Dados validados:', $validated);

            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $nomeArquivo = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $nomeArquivo);
                $validated['image_url'] = 'products/' . $nomeArquivo;
                \Log::info('Nova imagem salva:', ['image_url' => $validated['image_url']]);
            } else {
                $validated['image_url'] = $product->image_url;
            }

            if ($request->input('remove_image') == '1') {
                if ($product->image_url && file_exists(public_path($product->image_url))) {
                    @unlink(public_path($product->image_url));
                }
                $validated['image_url'] = null;
            }

            $validated['status'] = $request->has('status') ? true : false;
            \Log::info('Status definido:', ['status' => $validated['status']]);

            $product->update($validated);
            // Limpa o cache das páginas de produtos
            foreach (range(1, 10) as $page) {
                \Cache::forget('products_page_' . $page);
            }
            \Log::info('Produto atualizado com sucesso');

            return redirect('/lista-produtos')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar produto:', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Erro ao atualizar: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('cadastro-produto', compact('suppliers'));
    }

    public function produtosEsgotando()
{
    $produtos = Product::with('supplier')
    ->whereColumn('currentStock', '<=', 'minimumStock')
    ->paginate(20);

    return view('products.estoque-baixo', compact('produtos'));
}

public function enviarPedido(Request $request)
{
    $request->validate([
        'produto_id' => 'required|exists:products,id',
        'quantidade' => 'required|integer|min:1',
        'prazo' => 'nullable|string|max:100',
        'canal_envio' => 'required|in:email,whatsapp',
    ]);

    $produto = Product::with('supplier')->findOrFail($request->produto_id);
    $fornecedor = $produto->supplier;

    $mensagem = "Olá, {$fornecedor->name}. Gostaria de solicitar {$request->quantidade} unidades do produto '{$produto->description}'. Prazo de entrega: {$request->prazo}.
Em caso de dúvidas, entre em contato pelo e-mail: " . auth()->user()->email;


    // Envio por e-mail
    if ($request->canal_envio === 'email') {
        Mail::to($fornecedor->email)->send(
            new PedidoReposicaoMail(
                $fornecedor,
                $produto,
                $request->quantidade,
                $request->prazo,
                auth()->user()->email
            )
        );
    }

    // Registro de pedido
    SupplierOrder::create([
        'product_id' => $produto->id,
        'supplier_id' => $fornecedor->id,
        'quantidade' => $request->quantidade,
        'prazo_entrega' => $request->prazo,
        'canal_envio' => $request->canal_envio,
        'mensagem_enviada' => $mensagem,
    ]);

    // Envio via WhatsApp
    if ($request->canal_envio === 'whatsapp') {
        $telefone = preg_replace('/[^0-9]/', '', $fornecedor->phone ?? $fornecedor->contactNumber1);
        $responsavel = auth()->user()->name ?? 'Responsável pelo pedido';
        $mensagemWhats = "Olá, {$fornecedor->name}! Gostaria de solicitar {$request->quantidade} unidades do produto '{$produto->description}'. Prazo de entrega: {$request->prazo}. Em caso de dúvidas, entre em contato com {$responsavel}.";
        $mensagemURL = urlencode($mensagemWhats);
        $url = "https://wa.me/55{$telefone}?text={$mensagemURL}";

        // Em vez de redirect, envie a URL para a view para abrir em nova aba
        return back()->with('whatsapp_url', $url)->with('success', 'Clique no link para enviar o pedido via WhatsApp.');
    }
    return redirect()->route('produtos.esgotando')->with('success', 'Pedido enviado com sucesso!');
}



    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'barcode' => 'required|string|max:50',
            'code' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            'value' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
            'supplierId' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'currentStock' => 'nullable|integer',
            'minimumStock' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $nomeArquivo = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $nomeArquivo);
            $imagePath = 'products/' . $nomeArquivo;
        }

        $product = Product::create([
            'image_url' => $imagePath ?? null,
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'barcode' => $request->input('barcode'),
            'expiration_date' => $request->input('expiration_date'),
            'value' => $request->input('value'),
            'profit' => $request->input('profit'),
            'supplierId' => $request->input('supplierId'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'currentStock' => $request->input('currentStock'),
            'minimumStock' => $request->input('minimumStock'),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Se informou estoque inicial, cria movimentação de entrada automática
        if ($request->filled('currentStock') && (int)$request->input('currentStock') > 0) {
            \App\Models\Movement::create([
                'product_id' => $product->id,
                'type' => 'inward',
                'date' => now(),
                'quantity' => (int)$request->input('currentStock'),
                'cost' => $request->input('value') ?? 0,
                'note' => 'Entrada ao cadastrar produto',
            ]);
        }
        // Limpa o cache das páginas de produtos
        foreach (range(1, 10) as $page) {
            \Cache::forget('products_page_' . $page);
        }
        return redirect('/lista-produtos')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function massDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        foreach ($ids as $id) {
            $product = Product::find($id);
            if ($product) {
                // Opcional: deletar imagem do disco
                if ($product->image_url && file_exists(public_path($product->image_url))) {
                    @unlink(public_path($product->image_url));
                }
                $product->delete();
            }
        }
        return redirect('/lista-produtos')->with('success', 'Produtos excluídos com sucesso!');
    }
}
