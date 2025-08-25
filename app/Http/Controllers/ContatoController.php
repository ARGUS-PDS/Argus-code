<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function enviarContato(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'email' => 'required|email',
            'whatsapp' => 'required|string|max:20',
        ]);

        $destinatario = config('mail.from.address');

        Mail::raw(
            "Nova solicitação de contato:\n\n" .
            "Representante: {$validated['nome']}\n" .
            "Empresa: {$validated['empresa']}\n" .
            "Email: {$validated['email']}\n" .
            "WhatsApp: {$validated['whatsapp']}",
            function ($message) use ($destinatario) {
                $message->to($destinatario)
                        ->subject('Novo contato via formulário');
            }
        );

        return redirect()->back()->with('contato_enviado', true);
    }
}