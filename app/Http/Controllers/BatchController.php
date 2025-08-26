<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('movements')->get();
        return view('lote.index', compact('batches'));
    }


    public function create()
    {
        return view('lote.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_code' => 'required|string|max:100',
            'expiration_date' => 'required|date',
        ]);

        try {
            $batch = Batch::create($request->only('batch_code', 'expiration_date'));
            return response()->json($batch);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return redirect()->to('/entrada-saida?produto=' . urlencode($request->produto))
            ->with('success', 'Lote cadastrado com sucesso!');
    }

    public function buscarPorCodigo(Request $request)
    {
        $request->validate([
            'batch_code' => 'required|string'
        ]);

        $batch = \App\Models\Batch::with('product')
            ->where('batch_code', $request->batch_code)
            ->first();

        if (!$batch) {
            return response()->json([
                'success' => false,
                'message' => 'O código do lote não existe.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'produto' => $batch->product ? $batch->product->description : '-',
                'data_validade' => $batch->expiration_date,
                'data_entrada' => $batch->created_at->format('Y-m-d'),
            ]
        ]);
    }




    public function show(Batch $batches)
    {
        $batches->load('products');
        return view('lote.show', compact('batches'));
    }

    public function edit(Batch $batches)
    {
        return view('lote.edit', compact('batches'));
    }

    public function update(Request $request, Batch $batches)
    {
        $validated = $request->validate([
            'batch_code' => 'required|string|max:100|unique:batches,batch_code,' . $batches->id,
            'expiration_date' => 'required|date',
        ]);

        $batches->update($validated);

        return redirect()->route('batches.index')->with('success', 'Lote atualizado com sucesso!');
    }

    public function destroy(Batch $batches)
    {
        $batches->delete();

        return redirect()->route('batches.index')->with('success', 'Lote excluído com sucesso!');
    }
}
