<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgendamentoRequest;
use App\Models\Agendamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{

    public function storeAgendamento(StoreAgendamentoRequest $request)
    {
        $data = $request->validated();

        $conflito = Agendamento::where('profissional_id', $data['profissional_id'])
            ->where('data', $data['data'])
            ->where('horario_inicio', $data['horario_inicio'])
            ->exists();

        if ($conflito) {
            return back()->with('error', 'Este horário acabou de ser ocupado. Escolha outro.');
        }

        Agendamento::create($data);

        return back()->with('success', 'Agendamento realizado com sucesso!');
    }
}
