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
        $view = $request->query('view', 'diario'); // diario, semanal, mensal
        $dataSelecionada = $request->query('data', date('Y-m-d'));
        $carbonData = \Carbon\Carbon::parse($dataSelecionada);

        if ($view == 'semanal') {
            $inicio = $carbonData->copy()->startOfWeek();
            $fim = $carbonData->copy()->endOfWeek();
        } elseif ($view == 'mensal') {
            $inicio = $carbonData->copy()->startOfMonth();
            $fim = $carbonData->copy()->endOfMonth();
        } else {
            $inicio = $carbonData->copy()->startOfDay();
            $fim = $carbonData->copy()->endOfDay();
        }

        $horarios = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', "18:00"];

        $agendamentos = Agendamento::where('profissional_id', auth()->id())
            ->ativos()
            ->whereBetween('data', [$inicio, $fim])
            ->with('paciente')
            ->get();

        $pacientes = Paciente::visiveis()->get();

        return view('dashboard.agendamentos.index', compact(
            'horarios',
            'agendamentos',
            'dataSelecionada',
            'pacientes',
            'view'
        ));
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

        $agendamento = Agendamento::create($data);

        return back()->with('success', 'Agendamento realizado com sucesso!');
    }

    public function alteraStatusAtendimento(Agendamento $agendamento, Request $request)
    {
        $agendamento->status = $request->status;
        $agendamento->save();
        return back()->with('success', 'Status do agendamento alterado com sucesso!');
    }

}
