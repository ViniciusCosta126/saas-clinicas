<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToClinica
{
    protected static function bootBelongsToClinica()
    {
        static::addGlobalScope('clinica', function (Builder $builder) {
            // if (auth()->check() && auth()->user()->clinica_id) {
            //     $builder->where('clinica_id', auth()->user()->clinica_id);
            // }
        });
    }
}