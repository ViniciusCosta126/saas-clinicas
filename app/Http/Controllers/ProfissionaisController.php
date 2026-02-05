<?php

namespace App\Http\Controllers;

use App\Actions\Profissionais\CriarProfissional;
use App\Actions\Profissionais\EditarProfissional;
use App\Actions\Profissionais\ExcluirProfissional;
use App\Exceptions\CriarProfissionalException;
use App\Exceptions\EditarProfissionalException;
use App\Exceptions\ExcluirProfissionalException;
use App\Http\Requests\EditarProfissionalRequest;
use App\Http\Requests\StoreProfissional;
use App\Models\Agendamento;
use App\Models\Profissional;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfissionaisController extends Controller
{
    public function index()
    {
        $usuarios = User::select('email', 'cpf', 'name', 'created_at', 'role', 'id', 'clinica_id', 'telefone')->get();
        $profissionais = Profissional::paginate(10);

        return Inertia::render('Profissionais/Index',['profissionais'=>$profissionais,"usuarios"=>$usuarios]);
    }

    public function store(StoreProfissional $request,CriarProfissional $action)
    {
        try {
            $action->execute($request->validated());
            return back()->with('success',"Profissional foi criado com sucesso!");
        } catch (CriarProfissionalException $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    public function delete(int $profissional, ExcluirProfissional $action)
    {
        try {
            $action->execute($profissional);
            return back()->with('success', "Profissional apagado com sucesso!");
        } catch (ExcluirProfissionalException $th) {
            return back()->with("error", $th->getMessage());
        }
    }

    public function update(int $id, EditarProfissionalRequest $request, EditarProfissional $action)
    {
        try {
            $action->execute($id, $request->validated());
            return back()->with('success', "Profissional alterado com sucesso!");
        } catch (EditarProfissionalException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function buscarHorarios(Request $request)
    {
        $data = $request->query('data');
        $profissionalId = $request->query('profissional_id');

        $horariosPossiveis = [
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00'
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
            ->map(fn($hora) => Carbon::parse($hora)->format('H:i'))
            ->toArray();

        $disponiveis = array_values(array_diff($horariosPossiveis, $ocupados));

        return response()->json($disponiveis);
    }

}
