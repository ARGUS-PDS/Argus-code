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
}
