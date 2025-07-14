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

            if ($produtoSelecionado) {
                $movimentacoes = Movement::where('product_id', $produtoSelecionado->id)
                    ->orderBy('date', 'desc')
                    ->get();
            }
        }

        $entradas_valor = $entradas_qtd = $saidas_valor = $saidas_qtd = $lucro = $estoque_atual = 0;
        if ($produtoSelecionado) {
            $movimentacoes = Movement::where('product_id', $produtoSelecionado->id)
                ->orderBy('date', 'desc')
                ->get();
            $entradas_valor = $movimentacoes->whereIn('type', ['entrada', 'inward', 'Inward'])->sum('cost');
            $entradas_qtd   = $movimentacoes->whereIn('type', ['entrada', 'inward', 'Inward'])->sum('quantity');
            $saidas_valor   = $movimentacoes->whereIn('type', ['saida', 'outward', 'Outward'])->sum('cost');
            $saidas_qtd     = $movimentacoes->whereIn('type', ['saida', 'outward', 'Outward'])->sum('quantity');
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

        Movement::create($request->only([
            'product_id',
            'type',
            'date',
            'quantity',
            'cost',
            'note'
        ]));

        return redirect()->route('movimentacao.index')->with('success', 'Movimentação registrada com sucesso!');
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
        $movement->delete();

        return response()->json(['success' => true]);
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
