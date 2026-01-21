<?php

namespace App\Actions\Agendamento;

use App\Enums\StatusAgendamento;
use App\Exceptions\CriarAgendamentoException;
use App\Models\Agendamento;

class CriarAgendamento
{
    public function execute(array $dados): Agendamento
    {   
        $this->verificaConflitoProfissional($dados);
        $this->verificaConflitoPaciente($dados);

        return Agendamento::create([
            'clinica_id' => auth()->user()->clinica_id,
            'paciente_id' => $dados['paciente_id'],
            'profissional_id' => $dados['profissional_id'],
            'data' => $dados['data'],
            'horario_inicio' => $dados['horario_inicio'],
            'status' => StatusAgendamento::AGENDADO->value,
        ]);
    }

    private function verificaConflitoProfissional(array $dados)
    {
        $conflito = Agendamento::where('profissional_id', $dados['profissional_id'])
            ->where('data', $dados['data'])
            ->whereIn('status', [StatusAgendamento::AGENDADO->value, StatusAgendamento::CONFIRMADO->value])
            ->where('horario_inicio', $dados['horario_inicio'])
            ->exists();

        if ($conflito) {
            throw new CriarAgendamentoException('Ja existe um paciente marcado nesse horario pra você');
        }
    }
    private function verificaConflitoPaciente(array $dados)
    {
        $pacienteConflito = Agendamento::where('paciente_id', $dados['paciente_id'])
            ->where('data', $dados['data'])
            ->whereIn('status', [StatusAgendamento::AGENDADO->value, StatusAgendamento::CONFIRMADO->value])
            ->where('horario_inicio', $dados['horario_inicio'])
            ->exists();

        if ($pacienteConflito) {
            throw new CriarAgendamentoException('O paciente ja tem um agendamento neste horario.');
        }
    }
}