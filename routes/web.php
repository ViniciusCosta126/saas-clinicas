<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Rotas deslogadas

Route::get('/login', [HomeController::class, 'indexLogin'])->name('login');
Route::post('/login',[HomeController::class,'postLogin']);
Route::get('/criar-conta', [HomeController::class, 'criarConta'])->name('criar-conta');
Route::post('/criar-conta', [HomeController::class, 'postCriarConta']);


Route::middleware(['auth', 'has.clinica'])->group(function () {
    Route::prefix('dashboard')->group(function (){
        Route::get('/',[DashboardController::class,'index']);
        Route::get('/meu-perfil',[UserController::class,'show'])->name('meu-perfil');
        Route::post('/meu-perfil',[UserController::class,'updateInfosPessoais'])->name('update-meu-perfil');
    });
    Route::get('/logout',[HomeController::class,'logout']);
});