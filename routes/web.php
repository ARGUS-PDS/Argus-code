<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\SupplierController;


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

Route::get('/cadastrar-produto', function () {
    return view('cadastro-produto');
});
Route::post('/cadastrar-produto', [ProductController::class, 'store'])->name('products.store');

Route::get('/voltar', function () {
    return view('dashboard');
});

Route::get('/cadastrar-fornecedor', function () {
    return view('cadastro-fornecedor');
});

Route::get('/cadastrar-funcionario', function () {
    return view('cadastro-funcionario');
});

Route::get('/etiquetas', function () {
    return view('etiquetas');
});

Route::get('/etiquetas', [EtiquetaController::class, 'index']);
Route::post('/adicionar', [EtiquetaController::class, 'adicionar'])->name('etiquetas.adicionar');
Route::get('/limpar', [EtiquetaController::class, 'limpar'])->name('etiquetas.limpar');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
