<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendGridService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    protected SendGridService $sendGrid;

    public function __construct(SendGridService $sendGrid)
    {
        $this->sendGrid = $sendGrid;
    }

    public function enviarContato(Request $request)
    {
        // Log para debug
        Log::info('ContatoController: Iniciando envio', $request->all());

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'email' => 'required|email',
            'plano' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
        ]);

        Log::info('ContatoController: Dados validados', $validated);
        
        Log::debug('ContatoController: Dados que serão enviados para a view:', [
            'plano' => $validated['plano'],
            'nome' => $validated['nome'], 
            'empresa' => $validated['empresa'],
            'email' => $validated['email'],
            'whatsapp' => $validated['whatsapp']
        ]);

        try {
            $destinatario = config('mail.from.address', 'argontechsolut@gmail.com');
            $assunto = "Novo interesse no {$validated['plano']} - {$validated['nome']}";

            Log::info('ContatoController: Tentando enviar para', [
                'destinatario' => $destinatario,
                'assunto' => $assunto
            ]);

            $enviado = $this->sendGrid->sendContactEmail(
                array_merge($validated, [
                    'to' => $destinatario,
                    'subject' => $assunto,
                ])
            );

            // SEGUNDO: Se SendGrid falhar, tenta SMTP
            if (!$enviado) {
                Log::warning('SendGrid API falhou, tentando SMTP...');
                $enviado = $this->enviarViaSMTP($destinatario, $assunto, $validated);
            }

            if ($enviado) {
                Log::info('ContatoController: E-mail enviado com SUCESSO');
                return back()->with('contato_enviado', true);
            } else {
                Log::error('ContatoController: TODOS os métodos falharam');
                return back()->with('error', 'Falha ao enviar o e-mail. Tente novamente mais tarde.');
            }

        } catch (\Exception $e) {
            Log::error('ContatoController: Exceção: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'dados' => $validated,
            ]);

            return back()->with('error', 'Ocorreu um erro ao enviar o e-mail: ' . $e->getMessage());
        }
    }

    /**
     * Método fallback usando SMTP
     */
    protected function enviarViaSMTP($to, $subject, $data)
    {
        try {
            Log::info('Tentando enviar via SMTP...');
            
            // ✅ CORREÇÃO: Use config() em vez de env()
            Mail::send('emails.contato', $data, function ($message) use ($to, $subject) {
                $message->to($to)
                       ->subject($subject)
                       ->from(
                           config('mail.from.address', 'argontechsolut@gmail.com'),
                           config('mail.from.name', 'Argus')
                       );
            });

            Log::info('SMTP: E-mail enviado com sucesso');
            return true;

        } catch (\Exception $e) {
            Log::error('SMTP também falhou: ' . $e->getMessage());
            return false;
        }
    }
}