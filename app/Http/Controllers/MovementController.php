<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Movement;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $produtoSelecionado = null;
        $movimentacoes = [];
        $products = Product::orderBy('description')->get();

        if ($request->filled('produto')) {
            $produtoSelecionado = Product::where('description', 'like', '%' . $request->produto . '%')
                ->orWhere('barcode', 'like', '%' . $request->produto . '%')
                ->first();
        }

        $entradas_valor = $entradas_qtd = $saidas_valor = $saidas_qtd = $lucro = $estoque_atual = 0;
        if ($produtoSelecionado) {
            $movimentacoes = Movement::where('product_id', $produtoSelecionado->id)
                ->orderBy('date', 'desc')
                ->paginate(5);

            // Calcular totais diretamente no banco
            $entradas = Movement::where('product_id', $produtoSelecionado->id)
                ->whereIn('type', ['entrada', 'inward', 'Inward'])
                ->selectRaw('SUM(cost) as valor, SUM(quantity) as qtd')
                ->first();
            $saidas = Movement::where('product_id', $produtoSelecionado->id)
                ->whereIn('type', ['saida', 'outward', 'Outward'])
                ->selectRaw('SUM(cost) as valor, SUM(quantity) as qtd')
                ->first();

            $entradas_valor = $entradas->valor ?? 0;
            $entradas_qtd   = $entradas->qtd ?? 0;
            $saidas_valor   = $saidas->valor ?? 0;
            $saidas_qtd     = $saidas->qtd ?? 0;
            $lucro = $saidas_valor - $entradas_valor;
            $estoque_atual = $entradas_qtd - $saidas_qtd;
        }

        return view('entrada-saida', compact('products', 'produtoSelecionado', 'movimentacoes', 'entradas_valor', 'entradas_qtd', 'saidas_valor', 'saidas_qtd', 'lucro', 'estoque_atual'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:inward,outward',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'cost' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        $movement = Movement::create($request->only([
            'product_id',
            'type',
            'date',
            'quantity',
            'cost',
            'note'
        ]));

        $produto = Product::find($request->product_id);
        return redirect()->route('movimentacao.index', ['produto' => $produto ? $produto->description : null])
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    public function edit($id)
    {
        $movement = Movement::findOrFail($id);
        return response()->json($movement);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entrada,saida,balanco',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $movement = Movement::findOrFail($id);
        $movement->update($request->all());

        $produto = Product::find($request->product_id);

        return redirect()->route('movimentacao.index', ['produto' => $produto->description])
            ->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $movement = Movement::findOrFail($id);
        $produto = Product::find($movement->product_id);
        $movement->delete();

        return redirect()->route('movimentacao.index', ['produto' => $produto ? $produto->description : null])
            ->with('success', 'Movimentação excluída com sucesso!');
    }



    public function pesquisarProduto(Request $request)
    {
        return Product::where('description', 'like', '%' . $request->q . '%')->get(['id', 'description']);
    }

    public function searchProducts(Request $request)
    {
        $term = $request->get('term');

        $results = Product::where('description', 'like', '%' . $term . '%')
            ->limit(10)
            ->get(['id', 'description']);

        return response()->json($results);
    }
}
