<?php

namespace App\Models;

use App\Traits\FiltraPacientesPorAcesso;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Paciente
 * @property int $clinica_id
 * @property string $nome
 * @property string $email
 * @property string $telefone
 * @property \Carbon\Carbon $aniversario
 */
class Paciente extends Model
{
    use FiltraPacientesPorAcesso;
    protected $table = "pacientes";
    protected $fillable = [
        'clinica_id',
        'nome',
        'email',
        'telefone',
        'aniversario',
    ];

    protected $casts = [
        'aniversario' => 'date',
    ];
    
    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }
    public function profissionais()
    {
        return $this->belongsToMany(Profissional::class, 'paciente_profissional')
            ->withPivot(['iniciado_em', 'finalizado_em', 'clinica_id'])
            ->withTimestamps(false);
    }

    public function profissionalAtual()
    {
        return $this->profissionais()
            ->whereNull('paciente_profissional.finalizado_em');
    }

    public function getDataFormatadaAttribute()
    {
        return $this->aniversario
            ? $this->aniversario->format('d/m/Y')
            : null;
    }
}
