<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('products')->get();
        return view('lote.index', compact('batches'));
    }


    public function create()
    {
        return view('lote.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_code' => 'required|string|max:100|unique:batch,batch_code',
            'expiration_date' => 'required|date',
        ]);

        Batch::create($validated);

        return redirect()->route('batches.index')->with('success', 'Lote criado com sucesso!');
    }

    public function show(Batch $batch)
    {
        $batch->load('products');
        return view('lote.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        return view('lote.edit', compact('batch'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'batch_code' => 'required|string|max:100|unique:batch,batch_code,' . $batch->id,
            'expiration_date' => 'required|date',
        ]);

        $batch->update($validated);

        return redirect()->route('batches.index')->with('success', 'Lote atualizado com sucesso!');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('batches.index')->with('success', 'Lote excluído com sucesso!');
    }
}
