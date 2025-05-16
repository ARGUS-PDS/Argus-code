<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
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
            'image_url' => 'nullable|string|max:255',
        ]);

        // Ajusta status checkbox
        $validated['status'] = $request->has('status') ? true : false;

        // Upload imagem
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $path;
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }
}
