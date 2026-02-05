<?php

namespace App\Http\Controllers;

use App\Actions\Agendamento\CancelarAgendamento;
use App\Actions\Agendamento\ConcluirAgendamento;
use App\Actions\Agendamento\ConfirmaPresenca;
use App\Actions\Agendamento\CriarAgendamento;
use App\Actions\Agendamento\MarcaFaltaAgendamento;
use App\Exceptions\ConcluirAgendamentoException;
use App\Exceptions\ConfirmaAgendamentoException;
use App\Exceptions\CriarAgendamentoException;
use App\Exceptions\MarcaFaltaAgendamentoException;
use App\Http\Requests\StoreAgendamentoRequest;
use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\Profissional;
use Illuminate\Http\Request;
use App\Exceptions\CancelarAgendamentoException;
use Inertia\Inertia;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $dataSelecionada = $request->query('data', date('Y-m-d'));
        $view = $request->query('view', 'diario');
        $data = \Carbon\Carbon::parse($dataSelecionada);

        if ($view === 'semanal') {
            $inicio = $data->copy()->startOfWeek();
            $fim = $data->copy()->endOfWeek();
        } else {
            $inicio = $data->copy()->startOfDay();
            $fim = $data->copy()->endOfDay();
        }

        $agendamentos = Agendamento::where('profissional_id', auth()->id())
            ->ativos()
            ->whereBetween('data', [$inicio, $fim])
            ->with('paciente')
            ->get();

        return Inertia::render('Agendamentos/Index', [
            'agendamentos' => $agendamentos,
            'pacientes' => Paciente::visiveis()->get(),
            'profissionais'=>Profissional::all(),
            'dataSelecionada' => $dataSelecionada,
            'view' => $view,
            'horarios' => ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00']
        ]);
    }

    public function storeAgendamento(StoreAgendamentoRequest $request, CriarAgendamento $action)
    {
        try {
            $action->execute($request->validated());
            return back()->with('success', 'Agendamento realizado com sucesso!');
        } catch (CriarAgendamentoException $e) {
            \Log::error("Erro ao criar agendamento",['message'=>$e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelarAgendamento(int $id)
    {
        try {
            (new CancelarAgendamento())->execute($id);
            return redirect()->back()->with('success', 'Agendamento cancelado com sucesso.');
        } catch (CancelarAgendamentoException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function concluirAgendamento(int $id, ConcluirAgendamento $action)
    {
        try {
            $action->execute($id);
            return back()->with('success', "Agendamento concluido com sucesso!");
        } catch (ConcluirAgendamentoException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function faltaAgendamento(int $id, MarcaFaltaAgendamento $action)
    {
        try {
            $action->execute($id);
            return back()->with('success', "Falta marcada com sucesso!");
        } catch (MarcaFaltaAgendamentoException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function presencaAgendamento(int $id, ConfirmaPresenca $action)
    {
        try {
            $action->execute($id);
            return back()->with("success", "Presença confirmada com sucesso.");
        } catch (ConfirmaAgendamentoException $e) {
            return back()->with("error", $e->getMessage());
        }
    }
}
