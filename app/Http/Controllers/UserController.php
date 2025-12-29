<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(){
        return view('dashboard.meu-perfil.index');
    }

    public function updateInfosPessoais(Request $request){

        $user = User::where('id',Auth::user()->id)->first();

        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telefone = $request->telefone;
            $user->cpf = $request->cpf;
            $user->save();

            return to_route('meu-perfil');
        }
        return redirect('/dashboard');
    }
}
