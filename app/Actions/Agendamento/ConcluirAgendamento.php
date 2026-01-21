<?php


namespace App\Actions\Agendamento;

use App\Enums\StatusAgendamento;
use App\Exceptions\ConcluirAgendamentoException;
use App\Models\Agendamento;

class ConcluirAgendamento
{
    public function execute(int $agendamentoId)
    {
        $agendamento = Agendamento::findOrFail($agendamentoId);

        if ($agendamento->status === StatusAgendamento::CANCELADO->value) {
            throw new ConcluirAgendamentoException("Agendamento com status cancelado não pode ser concluido");
        }

        if ($agendamento->status === StatusAgendamento::CONCLUIDO->value) {
            throw new ConcluirAgendamentoException('Agendamento ja foi concluido');
        }

        $agendamento->update([
            "status" => StatusAgendamento::CONCLUIDO->value
        ]);
    }
}