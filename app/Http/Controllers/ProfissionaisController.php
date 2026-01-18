<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfissional;
use App\Models\Agendamento;
use App\Models\Profissional;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfissionaisController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        $profissionais = Profissional::paginate(10);
        return view('dashboard.profissionais.index', compact('profissionais', 'usuarios'));
    }

    public function store(StoreProfissional $request)
    {
        $dados = $request->validated();
        $profissional = Profissional::create($dados);
        return to_route("profissionais.index");
    }

    public function delete(Profissional $profissional)
    {
        $profissional->delete();
        return to_route("profissionais.index");
    }

    public function update(Profissional $profissional, Request $request)
    {
        $profissional->preco_sessao = $request->preco_sessao;
        $profissional->especialidade = $request->especialidade;
        $profissional->save();
        return to_route("profissionais.index");
    }

public function buscarHorarios(Request $request)
{
    $data = $request->query('data');
    $profissionalId = $request->query('profissional_id');

    $horariosPossiveis = [
        '08:00','09:00','10:00','11:00',
        '13:00','14:00','15:00','16:00',
        '17:00','18:00'
    ];

    $timezone = config('app.timezone');
    $dataSelecionada = Carbon::parse($data, $timezone);

    if ($dataSelecionada->isBefore(today($timezone))) {
        return response()->json([]);
    }

    if ($dataSelecionada->isToday()) {
        $agora = now($timezone);

        $horariosPossiveis = collect($horariosPossiveis)
            ->filter(function ($hora) use ($agora, $dataSelecionada, $timezone) {

                $dataHora = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $dataSelecionada->format('Y-m-d') . ' ' . $hora,
                    $timezone
                );

                return $dataHora->greaterThan($agora);
            })
            ->values()
            ->toArray();
    }

    $ocupados = Agendamento::where('profissional_id', $profissionalId)
        ->where('data', $data)
        ->whereIn('status', ['agendado', 'confirmado'])
        ->pluck('horario_inicio')
        ->map(fn ($hora) => Carbon::parse($hora)->format('H:i'))
        ->toArray();

    $disponiveis = array_values(array_diff($horariosPossiveis, $ocupados));

    return response()->json($disponiveis);
}

}
