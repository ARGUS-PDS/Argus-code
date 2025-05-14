<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $cartao_seg = trim($request->input('cartao_seg'));

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if (trim($user->cartao_seg) === $cartao_seg) {  
            $request->session()->regenerate();

            if ($user->email === 'argus@adm.com.br') {
                return redirect('/admin-dashboard'); 
            }

            return redirect()->intended('/dashboard');
        }

        Auth::logout();
        return back()->withErrors(['cartao_seg' => 'Cartão de segurança inválido.'])->withInput();
    }

    return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
}
}
