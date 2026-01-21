<?php

namespace App\Actions\Agendamento;

use App\Exceptions\CancelarAgendamentoException;
use App\Models\Agendamento;
use Carbon\Carbon;
use Exception;


class CancelarAgendamento
{
    public function execute(int $agendamentoId)
    {
        $agendemanto = Agendamento::findOrFail($agendamentoId);

        $horario = Carbon::parse($agendemanto->data->toDateString() . ' ' . $agendemanto->horario_inicio);
        if (now()->diffInMinutes($horario, false) < 60) {
            throw new CancelarAgendamentoException('Cancelamento permitido apenas com 1 hora de antecedencia');
        }

        $agendemanto->update([
            'status' => 'cancelado'
        ]);
    }
}