<?php

namespace App\Traits;

trait FiltraAgendamentosPorAcesso
{
    public function scopeVisiveis($query)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $query->where('clinica_id', $user->clinica_id);
        }

        return $query->where('profissional_id', $user->profissional_id)
            ->where('clinica_id', $user->clinica_id);
    }
}