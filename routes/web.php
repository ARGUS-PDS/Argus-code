<?php

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', function () {
    return 'Você está logado!';
})->middleware('auth');

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
})->middleware('auth');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
