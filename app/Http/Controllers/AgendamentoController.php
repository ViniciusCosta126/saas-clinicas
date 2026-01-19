<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgendamentoRequest;
use App\Models\Agendamento;
use App\Models\Paciente;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $dataSelecionada = $request->query('data', date('Y-m-d'));

        $horarios = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', "18:00"];

        $agendamentos = Agendamento::where('profissional_id', auth()->id())
            ->ativos()
            ->doDia($dataSelecionada)
            ->with('paciente')
            ->get();

        $pacientes = Paciente::visiveis()->get();

        return view('dashboard.agendamentos.index', compact('horarios', 'agendamentos', 'dataSelecionada', 'pacientes'));
    }

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

    public function alteraStatusAtendimento(Agendamento $agendamento,Request $request)
    {
        $agendamento->status = $request->status;
        $agendamento->save();
        return back()->with('success', 'Status do agendamento alterado com sucesso!');
    }
    
}
