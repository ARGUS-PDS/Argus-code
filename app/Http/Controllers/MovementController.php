<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $produto = null;

        if ($request->has('produto') && $request->produto) {
            $produto = Product::where('description', 'like', '%' . $request->produto . '%')->first();

            if ($produto) {
                $movimentacoes = Movement::where('product_id', $produto->id)
                    ->with('product')
                    ->orderBy('date', 'desc')
                    ->get();
            } else {
                $movimentacoes = collect(); // Nenhum produto encontrado
            }
        } else {
            $movimentacoes = Movement::with('product')
                ->orderBy('date', 'desc')
                ->get(); // Mostra todas as movimentações se não houver filtro
        }


        $products = Product::orderBy('description')->get();
        $entradas = Movement::where('type', 'inward')->sum('cost');
        $saidas = Movement::where('type', 'outward')->sum('cost');
        $lucro = $saidas - $entradas;

        return view('entrada-saida', compact('movimentacoes', 'produto', 'products', 'entradas', 'saidas', 'lucro'));
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
        $products = Product::all();
        return view('movement.edit', compact('movement', 'products'));
    }

    public function destroy($id)
    {
        $movement = Movement::findOrFail($id);
        $movement->delete();

        return redirect()->route('movimentacao.index')->with('success', 'Movimentação excluída com sucesso!');
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
