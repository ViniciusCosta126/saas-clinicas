<?php

namespace App\Actions\Paciente;

use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;

class CriarPacienteAction
{
    public function execute(array $dados, int $clinicaId, int $profissionalId): Paciente
    {
        $paciente = Paciente::create($dados);
        
        $paciente->profissionais()->attach($profissionalId, [
            'clinica_id' => $clinicaId,
            'iniciado_em' => now(),
        ]);

        return $paciente;
    }
}
