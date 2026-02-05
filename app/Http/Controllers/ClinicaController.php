<?php

namespace App\Http\Controllers;

use App\Actions\Clinica\EditarClinica;
use App\Exceptions\EditarClinicaException;
use App\Http\Requests\UpdateClinicaRequest;
use App\Models\Clinica;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClinicaController extends Controller
{
    public function index()
    {
        return Inertia::render('Clinica/Index');
    }
    public function getConfiguracoesClinica()
    {
        return Inertia::render('Clinica/Update');
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
