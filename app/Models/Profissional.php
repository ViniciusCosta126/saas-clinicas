<?php

namespace App\Models;

use App\Traits\BelongsToClinica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Profissional
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $especialidade
 * @property string $preco_sessao
 * @property int $clinica_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Profissional extends Model
{
    use SoftDeletes, BelongsToClinica;
    protected $table = 'profissionais';

    protected $fillable = [
        "nome",
        "email",
        "especialidade",
        "preco_sessao",
        'clinica_id',
        'user_id'
    ];

    protected $casts = [
        'preco_sessao' => 'decimal:2'
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
