<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


//Rotas deslogadas

Route::get('/login', [HomeController::class, 'indexLogin'])->name('login');
Route::post('/login',[HomeController::class,'postLogin']);
Route::get('/criar-conta', [HomeController::class, 'criarConta'])->name('criar-conta');
Route::post('/criar-conta', [HomeController::class, 'postCriarConta']);


Route::middleware(['auth', 'has.clinica'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Olá, esta é uma rota de teste sem controlador!';
    });
});