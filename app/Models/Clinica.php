<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Clinica
 *
 * @property int $id
 * @property string $nome_clinica
 * @property string $nome_responsavel
 * @property string $email
 * @property string $telefone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Clinica extends Model
{
    protected $fillable = ['nome_responsavel', 'nome_clinica', 'email', 'telefone'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function profissionais()
    {
        return $this->hasMany(Profissional::class);
    }
}
