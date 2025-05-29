<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtiquetaController extends Controller
{
    public function index(Request $request)
    {
        $etiquetas = json_decode($request->cookie('etiquetas', '[]'), true);
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

    return redirect('/')->with('error', 'Produto não encontrado.');
}


    public function limpar()
    {
        return redirect('/etiquetas')->withCookie(cookie('etiquetas', '', -1));
    }
}
