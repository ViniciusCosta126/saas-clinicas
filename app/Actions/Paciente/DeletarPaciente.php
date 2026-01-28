<?php


namespace App\Actions\Paciente;

use App\Enums\StatusAgendamento;
use App\Exceptions\DeletarPacienteException;
use App\Models\Agendamento;
use App\Models\Paciente;

class DeletarPaciente
{
    public function execute(int $id)
    {
        $paciente = Paciente::findOrFail($id);
        $this->validaRegrasDeNegocio($paciente);
        $paciente->delete();
    }

    private function validaRegrasDeNegocio(Paciente $paciente)
    {
        $agendamentos = Agendamento::where('profissional_id', $paciente->id)
            ->whereNotIn('status', [StatusAgendamento::CONCLUIDO->value, StatusAgendamento::NAO_COMPARECEU->value, StatusAgendamento::CANCELADO->value])
            ->exists();

        if ($agendamentos) {
            throw new DeletarPacienteException('Você não pode excluir um paciente que possui agendamentos');
        }
    }
}