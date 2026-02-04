<?php

namespace App\Http\Controllers;

use App\Actions\User\UpdateUserPasswordAction;
use App\Actions\User\UpdateUserProfileAction;
use App\Exceptions\UpdatePasswordException;
use App\Exceptions\UpdateProfileException;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(25);

        return Inertia::render('Usuarios/Index', ["usuarios" => $usuarios]);
    }
    public function show()
    {
        return Inertia::render('Usuarios/Show');
    }

    public function updateInfosPessoais(
        UpdateProfileRequest $request,
        UpdateUserProfileAction $action
    ) {
        try {
            $action->execute(auth()->user(), $request->validated());
            return back()->with('success', "Perfil atualizado com sucesso!");
        } catch (UpdateProfileException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateSenhaUsuario(
        UpdatePasswordRequest $request,
        UpdateUserPasswordAction $action
    ) {
        try {
            $action->execute(auth()->user(), $request->password);
            return back()->with('success', 'Senha atualizada com sucesso!');
        } catch (UpdatePasswordException $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function delete(User $usuario)
    {
        try {
            $usuario->delete();
            return back()->with("success", "Usuario deletado com sucesso");
        } catch (\Exception $th) {
            return back()->with("error", $th->getMessage());
        }

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
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            return back()->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro ao atualizar o usuário.');
        }
    }
}
