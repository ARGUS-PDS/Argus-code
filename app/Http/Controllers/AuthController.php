<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Facades\Hash;

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
        $remember = $request->has('remember'); 

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();

            if (trim($user->cartao_seg) !== $cartao_seg) {
                Auth::logout();
                return back()->withErrors([
                    'cartao_seg' => 'Cartão de segurança inválido.'
                ])->withInput();
            }

            $request->session()->regenerate();

            return $user->email === 'argus@adm.com.br'
                ? redirect('/admin-dashboard')
                : redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.'
        ])->withInput($request->only('email', 'remember'));
    }

    public function redirectToDashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $user->email === 'argus@adm.com.br'
                ? redirect('/admin-dashboard')
                : redirect('/dashboard');
        }

        return redirect()->route('login');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_photo_url')) {
            $uploadResult = CloudinaryHelper::upload($request->file('profile_photo_url')->getRealPath());

            if (isset($uploadResult['secure_url'])) {
                $user->profile_photo_url = $uploadResult['secure_url'];
                $user->save();
            } else {
                return redirect()->back()->withErrors(['error' => 'Erro ao enviar imagem para o Cloudinary.']);
            }
        }

        return redirect()->back()->with('success', 'Foto de perfil atualizada!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Senha atual incorreta.');
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}