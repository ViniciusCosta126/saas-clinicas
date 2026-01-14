<?php

namespace App\Models;

use App\Traits\FiltraAgendamentosPorAcesso;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use FiltraAgendamentosPorAcesso;
    protected $table = 'agendamentos';

    protected $fillable = [
        'clinica_id',
        'profissional_id',
        'paciente_id',
        'data',
        'horario_inicio',
        'horario_fim',
        'status',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function scopeDoDia($query, $data)
    {
        return $query->where('data', $data);
    }

    public function scopeAtivos($query)
    {
        return $query->whereIn('status', ['agendado', 'confirmado']);
    }
}
