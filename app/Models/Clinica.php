<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Clinica
 *
 * @property int $id
 * @property string $nome_clinica
 * @property string $nome_responsavel
 * @property string $email
 * @property string $telefone
 * @property string $preco_min_consulta
 * @property string $preco_max_consulta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Clinica extends Model
{
    use HasFactory;
    protected $fillable = ['nome_responsavel', 'nome_clinica', 'email', 'telefone', 'preco_min_consulta', 'preco_max_consulta'];
    protected $casts = [
        'preco_min_consulta' => "decimal:2",
        'preco_max_consulta' => "decimal:2"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function profissionais()
    {
        return $this->hasMany(Profissional::class);
    }
}
