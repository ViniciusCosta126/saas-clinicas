<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FiltraPacientesPorAcesso
{
    public function scopeVisiveis($query)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $query;
        }

        return $query->whereHas('profissionais', function ($q) use ($user) {
            $q->where('profissionais.id', $user->profissional_id)
                ->whereNull('paciente_profissional.finalizado_em');
        });
    }
}