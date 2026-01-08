<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use SoftDeletes;
    protected $table = 'profissionais';

    public function clinica(){
        return $this->belongsTo(Clinica::class);
    }
}
