<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('q') && $request->q) {
            $q = $request->q;
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('description', 'like', "%$q%")
                        ->orWhere('code', 'like', "%$q%");
            });
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
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
            'code' => 'required|string|max:255|unique:products,code,'.$product->id,
            'barcode' => 'required|string|max:50|unique:products,barcode,'.$product->id,
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
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $path;
        }

        $validated['status'] = $request->has('status') ? true : false;

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function create()
    {
        return view('cadastro-produto');
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

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
        }

        $validated['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $path;
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
