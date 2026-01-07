<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(10);
        return view('dashboard.usuarios.index', compact('usuarios'));
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

    public function delete(User $usuario)
    {
        $usuario->delete();
        return redirect('/usuarios');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,profissional,recepcao,financeiro',
        ]);

        try {
            $usuario = User::findOrFail($id);

            $usuario->update([
                'name' => $validated['name'],
                'telefone'=>$request->telefone,
                'cpf'=>$request->cpf,
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o usuário.');
        }
    }
}
