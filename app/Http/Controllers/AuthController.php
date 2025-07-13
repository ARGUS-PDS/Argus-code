<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'cartao_seg' => 'required'
        ]);

        $cartao_seg = trim($request->input('cartao_seg'));

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if (trim($user->cartao_seg) !== $cartao_seg) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'cartao_seg' => 'Cartão de segurança inválido.'
                ]);
            }

            $request->session()->regenerate();

            return $user->email === 'argus@adm.com.br' 
                ? redirect('/admin-dashboard')
                : redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Credenciais inválidas.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}