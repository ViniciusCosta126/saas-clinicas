<?php

namespace App\Actions\Agendamento;

use App\Enums\StatusAgendamento;
use App\Exceptions\MarcaFaltaAgendamentoException;
use App\Models\Agendamento;
use Carbon\Carbon;


class MarcaFaltaAgendamento
{
    public function execute(int $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if ($agendamento->status === StatusAgendamento::CANCELADO->value) {
            throw new MarcaFaltaAgendamentoException('Não é possivel marcar falta para um agendamento cancelado.');
        }

        if ($agendamento->status === StatusAgendamento::CONCLUIDO->value) {
            throw new MarcaFaltaAgendamentoException("Não é possivel marcar faltar para um agendamento concluido.");
        }
        
        if ($agendamento->status === StatusAgendamento::NAO_COMPARECEU->value) {
            throw new MarcaFaltaAgendamentoException(
                'Este agendamento já está marcado como falta.'
            );
        }

        $horario = Carbon::parse($agendamento->data->toDateString() . ' ' . $agendamento->horario_inicio);

        if (now()->lessThan($horario->copy()->addMinutes(5))) {
            throw new MarcaFaltaAgendamentoException(
                'Só é possível marcar falta após 5 minutos do horário do atendimento.'
            );
        }

        $agendamento->update([
            "status" => StatusAgendamento::NAO_COMPARECEU->value
        ]);
    }
}