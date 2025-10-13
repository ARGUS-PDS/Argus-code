<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtiquetaController extends Controller
{
    public function index(Request $request)
    {
        $etiquetas = json_decode($request->cookie('etiquetas', '[]'), true);
        
        if ($request->has('produto')) {
            $codigo = $request->input('produto');
            $produto = DB::table('products')
                ->where('barcode', $codigo)
                ->first();
            
            if ($produto) {
                $etiquetas = [[
                    'nome' => $produto->description,
                    'codigo' => $codigo,
                    'preco' => number_format($produto->value, 2, ',', '.')
                ]];
            }
        }
        
        if ($request->has('produtos')) {
            $codigos = explode(',', $request->input('produtos'));
            $etiquetas = [];
            
            foreach ($codigos as $codigo) {
                $codigo = trim($codigo);
                $produto = DB::table('products')
                    ->where('barcode', $codigo)
                    ->first();
                
                if ($produto) {
                    $etiquetas[] = [
                        'nome' => $produto->description,
                        'codigo' => $codigo,
                        'preco' => number_format($produto->value, 2, ',', '.')
                    ];
                }
            }
        }
        
        return view('etiquetas', compact('etiquetas'));
    }

    public function adicionar(Request $request)
    {
        $codigo = $request->input('codigo');

        $produto = DB::table('products')
            ->where('barcode', $codigo)
            ->first();

        if ($produto) {
            $etiquetas = json_decode($request->cookie('etiquetas', '[]'), true);

            $etiquetas[] = [
                'nome' => $produto->description,
                'codigo' => $codigo,
                'preco' => number_format($produto->value, 2, ',', '.')
            ];

            return redirect('/etiquetas')
                ->withCookie(cookie('etiquetas', json_encode($etiquetas), 60));
        }

        return redirect('/etiquetas')->with('error', 'Produto não encontrado.');
    }

    public function limpar()
    {
        return redirect('/etiquetas')->withCookie(cookie('etiquetas', '', -1));
    }

    public function excluir(Request $request)
    {
        $index = $request->input('index');
        $etiquetas = json_decode($request->cookie('etiquetas', '[]'), true);

        if (isset($etiquetas[$index])) {
            array_splice($etiquetas, $index, 1);
            $cookie = cookie('etiquetas', json_encode($etiquetas), 60);
            
            return response()->json(['success' => true])->withCookie($cookie);
        }

        return response()->json(['success' => false], 404);
    }
}