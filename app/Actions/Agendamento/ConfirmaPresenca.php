<?php

namespace App\Actions\Agendamento;

use App\Enums\StatusAgendamento;
use App\Exceptions\ConfirmaAgendamentoException;
use App\Exceptions\CriarAgendamentoException;
use App\Models\Agendamento;

class ConfirmaPresenca
{
    public function execute(int $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $this->validaRegrasDeNegocio($agendamento);

        $agendamento->update([
            "status" => StatusAgendamento::CONFIRMADO->value
        ]);
    }

    private function validaRegrasDeNegocio(Agendamento $agendamento)
    {
        if ($agendamento->status === StatusAgendamento::CANCELADO->value) {
            throw new ConfirmaAgendamentoException('Você não pode confirmar presença de um agendamento cancelado.');
        }

        if ($agendamento->status === StatusAgendamento::CONCLUIDO->value) {
            throw new ConfirmaAgendamentoException('Você não pode confirmar presença de um agendamento concluido.');
        }
    }
}