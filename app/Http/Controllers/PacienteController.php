<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestPaciente;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {

        $pacientes = Paciente::visiveis()->paginate(10);
        return view('dashboard.pacientes.index', compact('pacientes'));
    }

    public function store(StoreRequestPaciente $request)
    {
        $dados = $request->validated();
        $paciente = Paciente::create($dados);
        $profissional = auth()->user()->profissional;

        $paciente->profissionais()->attach($profissional->id, [
            'clinica_id' => auth()->user()->clinica_id,
            'iniciado_em' => now(),
        ]);

        return to_route("pacientes.index");
    }

    public function delete(Paciente $paciente)
    {
        $paciente->delete();
        return to_route("pacientes.index");
    }

    public function update(Paciente $paciente, StoreRequestPaciente $request)
    {

        $dados = $request->validated();


        $paciente->update($dados);

        return to_route('pacientes.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }

}
