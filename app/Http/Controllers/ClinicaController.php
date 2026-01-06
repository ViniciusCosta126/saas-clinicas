<?php

namespace App\Http\Controllers;

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

    public function update(Request $request, Clinica $clinica)
    {
        $validated = $request->validate([
            'nome_clinica' => 'required|string|max:255',
            'nome_responsavel' => 'required|string|max:255',
            'email' => 'required|email|unique:clinicas,email,' . $clinica->id,
            'telefone' => 'required|string|size:11',
        ]);

        $clinica->update($validated);

        return redirect()->route('clinica.index')->with('success', 'Dados atualizados!');
    }
}
