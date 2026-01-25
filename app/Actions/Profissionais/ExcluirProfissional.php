<?php

namespace App\Actions\Profissionais;

use App\Enums\StatusAgendamento;
use App\Exceptions\ExcluirProfissionalException;
use App\Models\Agendamento;
use App\Models\Profissional;

class ExcluirProfissional
{
    public function execute(int $id)
    {
        $profissional = Profissional::findOrFail($id);

        $this->validarRegrasDeNegocios($id);

        $profissional->delete();
    }

    private function validarRegrasDeNegocios(int $id)
    {
        $agendamentos = Agendamento::where('profissional_id', $id)
            ->whereNotIn('status', [StatusAgendamento::CONCLUIDO->value, StatusAgendamento::NAO_COMPARECEU->value, StatusAgendamento::CANCELADO->value])
            ->exists();

        if ($agendamentos) {
            throw new ExcluirProfissionalException('Você não pode excluir um profissional que possui agendamentos');
        }
    }
}