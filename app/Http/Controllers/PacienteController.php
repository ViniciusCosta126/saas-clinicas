<?php

namespace App\Http\Controllers;

use App\Actions\Paciente\CriarPacienteAction;
use App\Actions\Paciente\DeletarPaciente;
use App\Exceptions\CriarPacienteException;
use App\Exceptions\DeletarPacienteException;
use App\Http\Requests\StoreRequestPaciente;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::visiveis()->paginate(10);
        return view('dashboard.pacientes.index', compact('pacientes'));
    }

    public function store(StoreRequestPaciente $request, CriarPacienteAction $criarPaciente)
    {
        try {
            $criarPaciente->execute($request->validated(), Auth::user()->clinica_id, Auth::user()->profissional->id);
            return back()->with('success', "Paciente Criado com sucesso");
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
