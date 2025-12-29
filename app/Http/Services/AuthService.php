<?php

namespace App\Http\Services;

use App\Models\Clinica;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AuthService
{
    public function criarConta(array $request)
    {
        return DB::transaction(function () use ($request) {

            $clinica = Clinica::create([
                'nome_clinica' => $request['nome_clinica'],
                'nome_responsavel' => $request['nome_responsavel'],
                'email' => $request['email'],
                'telefone' => $request['telefone'],
            ]);
            

            $usuario = User::create([
                'name' => $request['nome_responsavel'],
                'email' => $request['email'],
                'password' => Hash::make($request['senha']),
                'clinica_id' => $clinica->id,
                'role' => 'admin'
            ]);

            Auth::login($usuario);

            return true;
        });
    }
}