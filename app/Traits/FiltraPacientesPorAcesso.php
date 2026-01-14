<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FiltraPacientesPorAcesso
{
    public function scopeVisiveis($query)
    {
        $user = auth()->user();
        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->role === 'admin') {
            return $query;
        }

        if (!$user->profissional) {
            return $query->whereRaw('1 = 0');
        }

        $profissionalId = $user->profissional->id;

        return $query->whereIn('pacientes.id', function ($sub) use ($profissionalId) {
            $sub->select('paciente_profissional.paciente_id')
                ->from('paciente_profissional')
                ->where('paciente_profissional.profissional_id', $profissionalId)
                ->whereNull('paciente_profissional.finalizado_em');
        });
    }


}