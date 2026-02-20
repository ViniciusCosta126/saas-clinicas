<?php

namespace App\Http\Controllers;

use App\Actions\Paciente\CriarPacienteAction;
use App\Actions\Paciente\DeletarPaciente;
use App\Exceptions\CriarPacienteException;
use App\Exceptions\DeletarPacienteException;
use App\Http\Requests\StoreRequestPaciente;
use App\Models\Paciente;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::visiveis()->with('clinica:id,nome_clinica')->paginate(10);
        $profissionais = Profissional::all();
        return Inertia::render('Pacientes/Index', ["pacientes" => $pacientes, "profissionais" => $profissionais]);
    }

    public function store(StoreRequestPaciente $request, CriarPacienteAction $criarPaciente)
    {
        try {
            if (Auth::user()->profissional) {
                $criarPaciente->execute($request->validated(), Auth::user()->clinica_id, Auth::user()->profissional->id);
                return back()->with('success', "Paciente Criado com sucesso");
            }
            throw new CriarPacienteException("Este usuario não tem um profissional atrelado a ele");
        } catch (CriarPacienteException $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function delete(int $paciente, DeletarPaciente $action)
    {
        try {
            $action->execute($paciente);
            return back()->with('success', "Paciente deletado com sucesso.");
        } catch (DeletarPacienteException $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function update(Paciente $paciente, StoreRequestPaciente $request)
    {
        $dados = $request->validated();
        $paciente->update($dados);

        return to_route('pacientes.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }
}
