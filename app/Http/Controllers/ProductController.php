<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierOrder;
use App\Mail\PedidoReposicaoMail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\CloudinaryHelper;

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

        $query = Product::select(['id', 'description', 'barcode', 'supplierId', 'value', 'image_url', 'brand', 'minimumStock'])
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

        // Filtros adicionais
        if ($request->filled('price_min')) {
            $query->where('value', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('value', '<=', (float) $request->price_max);
        }
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if ($request->filled('supplier_id')) {
            $query->where('supplierId', $request->supplier_id);
        }


        // Cache para listagem sem filtro (apenas quando não houver nenhum filtro aplicado)
        $hasAnyFilter = $request->filled('q') || $request->filled('price_min') || $request->filled('price_max') || $request->filled('brand') || $request->filled('supplier_id');
        if (!$hasAnyFilter) {
            $products = \Cache::remember('products_page_' . $request->get('page', 1), 60, function () use ($query) {
                return $query->paginate(10);
            });
        } else {
            $products = $query->paginate(10);
        }

        if ($request->ajax()) {
            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'description' => $product->description,
                    'barcode' => $product->barcode,
                    'value' => $product->value,
                    'supplier' => $product->supplier ? ['name' => $product->supplier->name] : null,
                    'image_url' => $product->image_url,
                    'image_exists' => !empty($product->image_url),
                    'edit_url' => route('products.edit', $product->id),
                ];
            });

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
            \Log::info('Tem arquivo?', [$request->hasFile('image_url')]);
            if ($request->hasFile('image_url')) {
                \Log::info('Arquivo recebido:', [$request->file('image_url')->getClientOriginalName()]);
            }

            $product = Product::findOrFail($id);
            \Log::info('Produto encontrado:', $product->toArray());

            $validated = $request->validate([
                'description' => ['required', 'string', 'max:255', 'regex:/.*\D.*/'],
                'barcode' => ['required', 'string', 'max:50', 'unique:products,barcode,' . $id],
                'code' => ['nullable', 'string', 'max:255', 'unique:products,code,' . $id],
                'value' => ['nullable', 'numeric', 'min:0'],
                'supplierId' => ['nullable', 'exists:suppliers,id'],
                'brand' => ['nullable', 'string', 'max:100', 'regex:/.*\D.*/'],
                'model' => ['nullable', 'string', 'max:100', 'regex:/.*\D.*/'],
                'currentStock' => ['nullable', 'integer', 'min:0'],
                'minimumStock' => ['nullable', 'integer', 'min:0'],
                'image_url' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            ], [
                'description.regex' => 'O nome não pode ser apenas números.',
                'brand.regex' => 'A marca não pode ser apenas números.',
                'model.regex' => 'O modelo não pode ser apenas números.',
            ]);


            \Log::info('Dados validados:', $validated);

            if ($request->hasFile('image_url')) {
                $uploadResult = \App\Helpers\CloudinaryHelper::upload($request->file('image_url')->getRealPath());
                $validated['image_url'] = $uploadResult['secure_url'] ?? null;
                \Log::info('Imagem enviada para Cloudinary:', ['url' => $validated['image_url']]);
            } else {
                $validated['image_url'] = $product->image_url;
            }

            if ($request->input('remove_image') == '1') {
                $validated['image_url'] = null;
            }

            $product->update($validated);

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

    public function produtosEsgotando(Request $request)
    {
        $perPage = 5;
        $page = $request->get('page', 1);

        // Subquery para calcular o estoque atual
        $estoqueSub = \DB::table('products as p')
            ->select(
                'p.id',
                'p.description',
                'p.minimumStock',
                'p.supplierId',
                \DB::raw("COALESCE(SUM(CASE 
                    WHEN m.type IN ('entrada', 'inward') THEN m.quantity
                    WHEN m.type IN ('saida', 'outward') THEN -m.quantity
                    ELSE 0 END), 0) as currentStock")
            )
            ->leftJoin('movements as m', 'm.product_id', '=', 'p.id')
            ->groupBy('p.id', 'p.description', 'p.minimumStock', 'p.supplierId');

        // Monta a query principal a partir da subquery
        $query = \DB::table(\DB::raw("({$estoqueSub->toSql()}) as estoque"))
            ->mergeBindings($estoqueSub)
            ->whereColumn('currentStock', '<=', 'minimumStock');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('description', 'like', "%$q%");
        }

        $produtos = $query->paginate($perPage, ['*'], 'page', $page);

        return view('products.estoque-baixo', ['produtos' => $produtos]);
    }

    public function listaProdutos()
    {
        $products = Product::select('id', 'description', 'code')->orderBy('description')->get();
        return response()->json($products);
    }



    public function enviarPedido(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:products,id',
            'quantidade' => 'required|integer|min:1',
            'prazo_valor' => 'required|integer|min:1',
            'prazo_unidade' => 'required|in:dia(s),semana(s),mês(es)',
            'canal_envio' => 'required|in:email,whatsapp',
        ]);

        $prazo = "{$request->prazo_valor} {$request->prazo_unidade}";

        $produto = Product::with('supplier')->findOrFail($request->produto_id);
        $fornecedor = $produto->supplier;

        $mensagem = "Olá, {$fornecedor->name}. Gostaria de solicitar {$request->quantidade} unidades do produto '{$produto->description}'. Prazo de entrega: {$prazo}.
Em caso de dúvidas, entre em contato pelo e-mail: " . auth()->user()->email;

        if ($request->canal_envio === 'email') {
            Mail::to($fornecedor->email)->send(
                new PedidoReposicaoMail(
                    $fornecedor,
                    $produto,
                    $request->quantidade,
                    $prazo,
                    auth()->user()->email
                )
            );
        }

        SupplierOrder::create([
            'product_id' => $produto->id,
            'supplier_id' => $fornecedor->id,
            'quantidade' => $request->quantidade,
            'prazo_entrega' => $prazo,
            'canal_envio' => $request->canal_envio,
            'mensagem_enviada' => $mensagem,
        ]);

        if ($request->canal_envio === 'whatsapp') {
            $telefone = preg_replace('/[^0-9]/', '', $fornecedor->phone ?? $fornecedor->contactNumber1);
            $responsavel = auth()->user()->name ?? 'Responsável pelo pedido';
            $mensagemWhats = "Olá, {$fornecedor->name}! Gostaria de solicitar {$request->quantidade} unidades do produto '{$produto->description}'. Prazo de entrega: {$prazo}. Em caso de dúvidas, entre em contato com {$responsavel}.";
            $mensagemURL = urlencode($mensagemWhats);
            $url = "https://wa.me/55{$telefone}?text={$mensagemURL}";

            return back()->with('whatsapp_url', $url)->with('success', 'Clique no link para enviar o pedido via WhatsApp.');
        }

        return redirect()->route('produtos.esgotando')->with('success', 'Pedido enviado com sucesso!');
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255', 'regex:/.*\D.*/'],
            'barcode' => ['required', 'string', 'max:50', 'unique:products,barcode'],
            'code' => ['nullable', 'string', 'max:255', 'unique:products,code'],
            'value' => ['nullable', 'numeric', 'min:0'],
            'supplierId' => ['nullable', 'exists:suppliers,id'],
            'brand' => ['nullable', 'string', 'max:100', 'regex:/.*\D.*/'],
            'model' => ['nullable', 'string', 'max:100', 'regex:/.*\D.*/'],
            'currentStock' => ['nullable', 'integer', 'min:0'],
            'minimumStock' => ['nullable', 'integer', 'min:0'],
            'image_url' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ], [
            'description.regex' => 'O nome não pode ser apenas números.',
            'brand.regex' => 'A marca não pode ser apenas números.',
            'model.regex' => 'O modelo não pode ser apenas números.',
        ]);

        // Faz upload para Cloudinary
        $uploadedFileUrl = null;
        if ($request->hasFile('image_url')) {
            $uploadResult = CloudinaryHelper::upload($request->file('image_url')->getRealPath());
            $uploadedFileUrl = $uploadResult['secure_url'] ?? null;
        }


        $product = Product::create([
            'image_url' => $imagePath ?? null,
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'barcode' => $request->input('barcode'),
            //'expiration_date' => $request->input('expiration_date'),
            'value' => $request->input('value'),
            //'profit' => $request->input('profit'),
            'supplierId' => $request->input('supplierId'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'currentStock' => $request->input('currentStock'),
            'minimumStock' => $request->input('minimumStock'),
            'image_url' => $uploadedFileUrl,
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
        try {
            $ids = $request->input('ids', []);

            // Validar se há IDs
            if (empty($ids) || empty(array_filter($ids))) {
                return response()->json(['error' => 'Nenhum ID fornecido'], 400);
            }

            // Validar se os IDs são números
            $ids = array_filter($ids, function ($id) {
                return is_numeric($id) && $id > 0;
            });

            if (empty($ids)) {
                return response()->json(['error' => 'IDs inválidos'], 400);
            }

            \Log::info('Tentando excluir produtos:', ['ids' => $ids]);

            $deleted = Product::whereIn('id', $ids)->delete();

            \Log::info('Produtos excluídos:', ['count' => $deleted]);

            foreach (range(1, 10) as $page) {
                \Cache::forget('products_page_' . $page);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'deleted' => $deleted]);
            }

            return redirect()->route('products.index')->with('success', 'Produtos excluídos com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir produtos em massa:', [
                'error' => $e->getMessage(),
                'ids' => $request->input('ids'),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => 'Erro interno do servidor'], 500);
            }

            return redirect()->route('products.index')->with('error', 'Erro ao excluir produtos.');
        }
    }
}
