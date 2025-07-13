<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierOrderController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\CompanyController;


Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/admin-dashboard', function () {
    return view('admin.admin-dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/gerar-cartao', [AdminController::class, 'formGerarCartao'])->name('admin.cartao');
    Route::post('/admin/gerar-cartao', [AdminController::class, 'gerarCartao'])->name('admin.gerarCartao');
});

Route::get('/cadastrar-produto-ean', function () {
    return view('codigo-de-barras');
});



Route::get('/cadastrar-produto', [ProductController::class, 'create'])->name('cadastrar-produto');
Route::post('/cadastrar-produto', [ProductController::class, 'store'])->name('cadastrar-produto.store');
Route::get('/lista-produtos', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::resource('products', ProductController::class);
Route::get('/pesquisa', [ProductController::class, 'index'])->name('pesquisa.index');
Route::get('/produtos/busca', [App\Http\Controllers\ProductController::class, 'buscaJson'])->name('produtos.buscaJson');


Route::get('/voltar', function () {
    return view('dashboard');
});

Route::resource('suppliers', SupplierController::class);
Route::resource('address', AddressController::class);
Route::get('/cadastrar-fornecedor', function () {
    return view('cadastro-fornecedor');
});
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/lista-fornecedores', [SupplierController::class, 'index']);
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::post('/cadastrar-fornecedor', [SupplierController::class, 'store'])->name('cadastrar-fornecedor.store');
Route::get('/pesquisa', [SupplierController::class, 'index'])->name('pesquisa.index');

// Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
// Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
// Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);
Route::post('/suppliers/{supplierId}/addresses', [AddressController::class, 'store']);
// Route::put('/addresses/{id}', [AddressController::class, 'update']);
// Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

Route::get('/cadastrar-funcionario', function () {
    return view('cadastro-funcionario');
});

Route::get('/detalhamento-lote', function () {
    return view('lote.detalhamento');
});

Route::get('/entrada-saida', function () {
    return view('entrada-saida');
});

Route::get('/etiquetas', [EtiquetaController::class, 'index']);
Route::post('/adicionar', [EtiquetaController::class, 'adicionar'])->name('etiquetas.adicionar');
Route::get('/limpar', [EtiquetaController::class, 'limpar'])->name('etiquetas.limpar');


Route::get('/alerta-estoque', [ProductController::class, 'produtosEsgotando'])->name('produtos.esgotando');
Route::post('/enviar-pedido', [ProductController::class, 'enviarPedido'])->name('pedido.enviar');
Route::get('/pedidos-enviados', [SupplierOrderController::class, 'index'])->name('orders.index');

Route::get('/entrada-saida', [MovementController::class, 'index'])->name('movimentacao.index');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
});

Route::get('lang/{locale}', function (string $locale) {
    if (in_array($locale, ['pt_BR', 'en'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return back();
})->name('lang.switch');
