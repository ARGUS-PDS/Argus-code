<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $batchCode = $request->batch_code ?? null;

        if (!$batchCode) {
            $batches = \App\Models\Batch::with('product')->get();

            return response()->json([
                'success' => true,
                'all' => true,
                'data' => $batches->map(function ($batch) {
                    return [
                        'id' => $batch->id,
                        'lote' => $batch->batch_code,
                        'produto' => $batch->product ? $batch->product->description : '-',
                        'data_validade' => $batch->expiration_date,
                        'data_entrada' => $batch->created_at->format('Y-m-d'),
                    ];
                })
            ]);
        }

        $batch = \App\Models\Batch::with('product')
            ->where('batch_code', $batchCode)
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


    public function buscarPorProduto(Request $request)
    {
        $produto = $request->produto;

        $batches = Batch::with('product')
            ->whereHas('product', function($q) use ($produto) {
                $q->where('description', 'like', "%$produto%")
                ->orWhere('code', 'like', "%$produto%");
            })->get();

        if ($batches->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Nenhum lote encontrado para este produto.']);
        }

        return response()->json([
            'success' => true,
            'data' => $batches->map(function($batch) {
                return [
                    'batch_code' => $batch->batch_code,
                    'produto' => $batch->product->description ?? '-',
                    'data_validade' => $batch->expiration_date ? Carbon::parse($batch->expiration_date)->format('d/m/Y') : '00/00/0000',
                    'data_entrada' => optional($batch->created_at)->format('d/m/Y') ?? '00/00/0000',
                ];
            })
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


    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();
        // Limpa o cache das páginas de produtos
        foreach (range(1, 10) as $page) {
            \Cache::forget('products_page_' . $page);
        }
        return redirect('/detalhamento-lote')->with('success', 'Lote excluído com sucesso!');
    }

    public function destroyByCode($batch_code)
    {
        $batch = Batch::where('batch_code', $batch_code)->first();

        if (!$batch) {
            return redirect('/detalhamento-lote')->with('error', 'Lote não encontrado!');
        }

        $batch->delete();

        // Limpa cache de produtos (mesma lógica do destroy normal)
        foreach (range(1, 10) as $page) {
            \Cache::forget('products_page_' . $page);
        }

        return redirect('/detalhamento-lote')->with('success', 'Lote excluído com sucesso!');
    }
}
