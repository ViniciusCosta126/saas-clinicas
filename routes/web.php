<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


//Rotas deslogadas

Route::get('/login',[HomeController::class,'indexLogin']);
Route::get('/criar-conta',[HomeController::class,'criarConta']);
