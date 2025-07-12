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
        $query = Product::query();

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('description', 'like', "%$q%")
                    ->orWhere('code', 'like', "%$q%");
            });
        }

        $products = $query->paginate(20);

        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'barcode' => 'required|string|max:50|unique:products,barcode,' . $product->id,
            'description' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'value' => 'required|numeric',
            'profit' => 'required|numeric',
            'supplierId' => 'required|exists:suppliers,id',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'currentStock' => 'required|integer',
            'minimumStock' => 'required|integer',
            'status' => 'boolean',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $nomeArquivo = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $nomeArquivo);
            $validated['image_url'] = 'products/' . $nomeArquivo;
        }


        $validated['status'] = $request->has('status') ? true : false;

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
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
            'code' => 'required|string|max:255|unique:products',
            'barcode' => 'required|string|max:50|unique:products',
            'description' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'value' => 'required|numeric',
            'profit' => 'required|numeric',
            'supplierId' => 'required|exists:suppliers,id',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'currentStock' => 'required|integer',
            'minimumStock' => 'required|integer',
            'status' => 'boolean',
            'image_url' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);



        $validated['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $nomeArquivo = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $nomeArquivo);
            $imagePath = 'products/' . $nomeArquivo;
        }


        Product::create([
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

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }
}
