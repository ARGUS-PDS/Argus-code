<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function formGerarCartao()
    {
        $usuarios = User::all();
        return view('admin.gerar-cartao', compact('usuarios'));
    }

    public function gerarCartao(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $cartaoCompleto = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $ultimos4 = substr($cartaoCompleto, -4);

        $user->cartao_seg = $ultimos4;
        $user->save();

        return redirect()->route('admin.cartao')
            ->with('cartao', $cartaoCompleto)
            ->with('user_id', $user->id);
    }

    public function dashboard()
    {
        $produtos_validade = \App\Models\Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', now())
            ->whereDate('expiration_date', '<=', now()->addMonths(6))
            ->orderBy('expiration_date')
            ->get();

        // Últimas 10 movimentações
        $movimentacoes = \App\Models\Movement::with('product')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $produtos_vencidos = \App\Models\Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', now())
            ->orderBy('expiration_date')
            ->get();

        return view('dashboard', compact('produtos_validade', 'movimentacoes', 'produtos_vencidos'));
    }
}
