<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClinicaRequest;
use App\Models\Clinica;
use Illuminate\Http\Request;

class ClinicaController extends Controller
{
    public function index()
    {
        $clinica = auth()->user()->clinica;
        return view('dashboard.clinica.index', compact('clinica'));
    }
    public function getConfiguracoesClinica()
    {
        $clinica = auth()->user()->clinica;
        return view('dashboard.clinica.update', compact('clinica'));
    }

    public function update(UpdateClinicaRequest $request)
    {

        $clinica = auth()->user()->clinica;
        $clinica->update($request->validated());

        return redirect()
            ->route('clinica.index')
            ->with('success', 'Dados da clínica atualizados com sucesso!');
    }
}
