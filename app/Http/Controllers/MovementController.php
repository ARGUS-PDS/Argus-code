<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $movimentacoes = [];
        $produto = null;

        if ($request->has('produto')) {
            $produto = Product::where('description', 'like', '%' . $request->produto . '%')->first();

            if ($produto) {
                $movimentacoes = Movement::where('product_id', $produto->id)->orderBy('data', 'desc')->get();
            }
        }

        $products = Product::orderBy('name')->get();


        return view('entrada-saida', compact('movimentacoes', 'produto', 'products'));
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

        return redirect()->route('movimentacao.index', ['produto' => $request->input('product_name')])
            ->with('success', 'Stock movement registered successfully!');
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
