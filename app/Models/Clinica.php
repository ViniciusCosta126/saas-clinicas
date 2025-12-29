<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $fillable = ['nome', 'email', 'telefone'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
