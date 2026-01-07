<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserInvites
 *
 * @property int $id
 * @property string $email
 * @property string $nome
 * @property int $clinica_id
 * @property string $role
 * @property string $token
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class UserInvites extends Model
{
    protected $fillable = [
        'email',
        'nome',
        'clinica_id',
        'role',
        'token',
        'expires_at',
        'used_at',
    ];
}
