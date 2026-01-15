<?php

use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfissionaisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInviteController;
use Illuminate\Support\Facades\Route;


//Rotas deslogadas
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'indexLogin'])->name('login');
Route::post('/login', [HomeController::class, 'postLogin']);
Route::get('/criar-conta', [HomeController::class, 'criarConta'])->name('criar-conta');
Route::post('/criar-conta', [HomeController::class, 'postCriarConta']);
Route::get('/criar-conta-convite/{token}', [HomeController::class, "criarContaConvite"]);
Route::post('/criar-conta-convite/{convite}', [HomeController::class, "postCriarContaConvite"])->name('usuarios.criar-conta.invite');


//Rotas Logadas
Route::middleware(['auth', 'has.clinica'])->group(function () {
    Route::get('/logout', [HomeController::class, 'logout']);
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
    });

    Route::prefix('clinica')->group(function () {
        Route::get('/', [ClinicaController::class, "index"])->name('clinica.index');
        Route::get('/configuracoes-clinica', [ClinicaController::class, 'getConfiguracoesClinica'])->middleware('permission:config.manage')->name('config.manage');
        Route::put('/configuracoes-clinica/{clinica}', [ClinicaController::class, ' '])->middleware('permission:config.manage')->name('clinica.update');
    });

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:usuarios')->name('usuarios.index');
        Route::put('/update/{id}', [UserController::class, 'update'])->middleware('permission:usuarios');
        Route::get('/meu-perfil', [UserController::class, 'show'])->name('meu-perfil');
        Route::post('/meu-perfil', [UserController::class, 'updateInfosPessoais'])->name('update-meu-perfil');
        Route::put('/meu-perfil', [UserController::class, 'updateSenhaUsuario'])->name('update-senha');
        Route::delete('/delete/{usuario}', [UserController::class, 'delete'])->middleware('permission:usuarios')->name('usuarios.delete');
        Route::post('/envio-convite-clinica', [UserInviteController::class, 'envioConviteClinica'])->middleware('permission:usuarios')->name('usuarios.invites.store');
    });

    Route::prefix('profissionais')->group(function () {
        Route::get('/', [ProfissionaisController::class, 'index'])->middleware('permission:profissionais.manage')->name("profissionais.index");
        Route::post('/', [ProfissionaisController::class, 'store'])->middleware('permission:profissionais.manage')->name("profissionais.store");
        Route::delete('/{profissional}', [ProfissionaisController::class, 'delete'])->middleware('permission:profissionais.manage')->name("profissionais.delete");
        Route::put("/update/{profissional}", [ProfissionaisController::class, "update"])->middleware('permission:profissionais.manage');
    });

    Route::prefix('pacientes')->group(function (){
        Route::get('/',[PacienteController::class,'index'])->middleware('permission:pacientes.manage')->name('pacientes.index');
        Route::post('/',[PacienteController::class,'store'])->name('pacientes.store');
        Route::delete('/delete/{paciente}',[PacienteController::class,'delete'])->name('pacientes.delete');
        Route::put('/update/{paciente}',[PacienteController::class,'update']);
    });
});