<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Certifique-se de que o model User está correto

class SupportController extends Controller
{
    public function senhaVencida(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'cartao_seg' => 'required|digits:4',
        ]);

        $usuario = User::where('email', $validated['email'])
                        ->where('cartao_seg', $validated['cartao_seg'])
                        ->first();

        if (!$usuario) {
            return redirect()->back()
                ->withErrors(['email' => 'Email ou final do cartão de segurança inválido.'], 'suporte')
                ->withInput();
        }

        $destinatario = config('mail.from.address'); 

        try {
            Mail::raw(
                "Teste de envio de e-mail",
                function ($message) use ($destinatario) {
                    $message->from(config('mail.mailers.smtp.username'), 'Suporte Sistema');
                    $message->to($destinatario)
                            ->subject('Teste');
                }
            );
        } catch (\Exception $e) {
            dd($e->getMessage()); // mostra erro se houver
        }


        return redirect()->back()->with('contato_enviado', true);
    }
}
