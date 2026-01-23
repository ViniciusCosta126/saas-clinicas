<?php

namespace App\Http\Controllers;

use App\Actions\Clinica\EditarClinica;
use App\Exceptions\EditarClinicaException;
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

    public function update(int $clinica, UpdateClinicaRequest $request, EditarClinica $action)
    {
        try {
            $action->execute($clinica, $request->validated());
            return back()->with('success', 'Dados da clínica atualizados com sucesso!');
        } catch (EditarClinicaException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
