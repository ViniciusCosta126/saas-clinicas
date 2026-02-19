<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\Profissional;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $mesSelecionado = request('mes');
        $comparar = request('comparar', 'mes');

        $dataBase = $mesSelecionado
            ? Carbon::createFromFormat('Y-m', $mesSelecionado)
            : Carbon::now();

        $profissionais = Profissional::count();
        $pacientes = Paciente::visiveis()->count();

        $agendamentos = Agendamento::doDia($dataBase->toDateString())
            ->ativos()
            ->visiveis()
            ->count();

        $faturamentoDia = Agendamento::doDia($dataBase->toDateString())
            ->visiveis()
            ->cobranca()
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->sum('profissionais.preco_sessao');

        $inicio7 = $dataBase->copy()->subDays(6)->startOfDay();
        $fim7 = $dataBase->copy()->endOfDay();

        $faturamentoGrafico = Agendamento::visiveis()
            ->cobranca()
            ->whereBetween('agendamentos.data', [$inicio7, $fim7])
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->selectRaw('DATE(agendamentos.data) as data, SUM(profissionais.preco_sessao) as total')
            ->groupBy('data')
            ->orderBy('data')
            ->get()
            ->map(fn($i) => [
                'data' => Carbon::parse($i->data)->format('d/m'),
                'total' => (float) $i->total,
            ]);

        $inicioMes = $dataBase->copy()->startOfMonth();
        $fimMes = $dataBase->copy()->endOfMonth();

        $faturamentoMensal = Agendamento::visiveis()
            ->cobranca()
            ->whereBetween('agendamentos.data', [$inicioMes, $fimMes])
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->selectRaw('DATE(agendamentos.data) as data, SUM(profissionais.preco_sessao) as total')
            ->groupBy('data')
            ->orderBy('data')
            ->get()
            ->map(fn($i) => [
                'data' => Carbon::parse($i->data)->format('d/m'),
                'total' => (float) $i->total,
            ]);

        if ($comparar === 'ano') {
            $inicioAnterior = $dataBase->copy()->subYear()->startOfMonth();
            $fimAnterior = $dataBase->copy()->subYear()->endOfMonth();
        } else {
            $inicioAnterior = $dataBase->copy()->subMonth()->startOfMonth();
            $fimAnterior = $dataBase->copy()->subMonth()->endOfMonth();
        }

        $atual = Agendamento::visiveis()
            ->cobranca()
            ->whereBetween('agendamentos.data', [$inicioMes, $fimMes])
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->sum('profissionais.preco_sessao');

        $anterior = Agendamento::visiveis()
            ->cobranca()
            ->whereBetween('agendamentos.data', [$inicioAnterior, $fimAnterior])
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->sum('profissionais.preco_sessao');

        $faturamentoPorProfissional = Agendamento::visiveis()
            ->cobranca()
            ->whereBetween('agendamentos.data', [$inicioMes, $fimMes])
            ->join('profissionais', 'profissionais.id', '=', 'agendamentos.profissional_id')
            ->selectRaw('
                profissionais.nome as profissional,
                SUM(profissionais.preco_sessao) as total
            ')
            ->groupBy('profissionais.id', 'profissionais.nome')
            ->orderByDesc('total')
            ->get()
            ->map(fn($i) => [
                'profissional' => $i->profissional,
                'total' => (float) $i->total,
            ]);

        return Inertia::render('Dashboard', [
            'profissionais' => $profissionais,
            'pacientes' => $pacientes,
            'agendamentos' => $agendamentos,
            'faturamento' => (float) $faturamentoDia,
            'faturamentoGrafico' => $faturamentoGrafico,
            'faturamentoMensal' => $faturamentoMensal,
            'faturamentoPorProfissional' => $faturamentoPorProfissional,
            'comparativoMensal' => [
                'atual' => (float) $atual,
                'anterior' => (float) $anterior,
                'variacao' => $anterior > 0
                    ? round((($atual - $anterior) / $anterior) * 100, 2)
                    : 100
            ],
            'mesSelecionado' => $dataBase->format('Y-m'),
        ]);
    }
}
