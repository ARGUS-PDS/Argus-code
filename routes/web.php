<?php

use App\Http\Controllers\AuthController;

use illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard'); 
})->middleware('auth');

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
})->middleware('auth');

Route::get('/cadastrar-produto-ean', function () {
    return view('codigo-de-barras');
});

Route::get('/voltar', function () {
    return view('dashboard');
});

Route::get('/cadastrar-produto', function () {
    return view('cadastro-produto');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
