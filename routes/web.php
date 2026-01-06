<?php

use App\Http\Controllers\ClinicaController;
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
    });
    Route::get('/meu-perfil',[UserController::class,'show'])->name('meu-perfil');
    Route::post('/meu-perfil',[UserController::class,'updateInfosPessoais'])->name('update-meu-perfil');
    Route::put('/meu-perfil',[UserController::class,'updateSenhaUsuario'])->name('update-senha');
    Route::prefix('clinica')->group(function (){
        Route::get('/',[ClinicaController::class,"index"])->name('clinica.index');
        Route::get('/configuracoes-clinica',[ClinicaController::class,'getConfiguracoesClinica'])->middleware('permission:config.manage')->name('config.manage');
        Route::put('/configuracoes-clinica/{clinica}',[ClinicaController::class,'update'])->middleware('permission:config.manage')->name('clinica.update');
    });
    Route::get('/logout',[HomeController::class,'logout']);
});