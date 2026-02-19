<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;


trait FiltraAgendamentosPorAcesso
{
    public function scopeVisiveis($query)
    {
        $user = Auth::user();

        if (!$user) {
            return $query;
        }

        if ($user->role === 'admin') {
            return $query->where('agendamentos.clinica_id', $user->clinica_id);
        }

        return $query
            ->where('agendamentos.clinica_id', $user->clinica_id)
            ->where('agendamentos.profissional_id', $user->profissional->id);
    }
}
