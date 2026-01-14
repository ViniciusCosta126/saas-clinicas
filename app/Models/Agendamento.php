<?php

namespace App\Models;

use App\Traits\FiltraAgendamentosPorAcesso;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Agendamento
 * @property int $clinica_id
 * @property int $profissional_id
 * @property int $paciente_id
 * @property \Carbon\Carbon $data
 * @property string $horario_inicio
 * @property string $horario_fim
 * @property string $status
 */
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
    protected $casts = [
        'data' => 'date',
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

    public function getDataFormatadaAttribute()
    {
        return $this->data
            ? $this->data->format('d/m/Y')
            : null;
    }

    public function getHorarioInicioFormatadoAttribute()
    {
        return $this->horario_inicio
            ? Carbon::createFromFormat('H:i:s', $this->horario_inicio)->format('H:i')
            : null;
    }

    public function getHorarioFimFormatadoAttribute()
    {
        return $this->horario_fim
            ? Carbon::createFromFormat('H:i:s', $this->horario_fim)->format('H:i')
            : null;
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'agendado' => 'Agendado',
            'confirmado' => 'Confirmado',
            'concluído' => 'Concluído',
            'cancelado' => 'Cancelado',
            'nao_compareceu' => 'Não compareceu',
            default => ucfirst($this->status),
        };
    }
}
