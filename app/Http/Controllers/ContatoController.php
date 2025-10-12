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
            'plano' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
        ]);

        $destinatario = config('mail.from.address');

        Mail::send('emails.contato', $validated, function ($message) use ($destinatario, $validated) {
            $message->to($destinatario)
                    ->subject("Novo interesse no {$validated['plano']}");
        });

        return redirect()->back()->with('contato_enviado', true);
    }
}