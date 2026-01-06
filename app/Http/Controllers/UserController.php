<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(){
        return view('dashboard.usuarios.index');
    }
    public function show()
    {
        return view('dashboard.meu-perfil.index');
    }

    public function updateInfosPessoais(Request $request)
    {

        $user = User::where('id', Auth::user()->id)->first();

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telefone = $request->telefone;
            $user->cpf = $request->cpf;
            $user->save();

            return to_route('meu-perfil');
        }
        return redirect('/dashboard');
    }

    public function updateSenhaUsuario(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
        ], [
            'current_password.current_password' => 'A senha atual está incorreta.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Senha atualizada com sucesso!');
    }


}
