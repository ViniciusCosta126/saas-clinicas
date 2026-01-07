<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToClinica
{
    protected static function bootBelongsToClinica()
    {
        if (app()->runningInConsole()) {
            return;
        }

        static::addGlobalScope('clinica', function (Builder $builder) {
            if (auth()->hasUser()) {
                $user = auth()->user();
                if ($user->clinica_id && $builder->getModel()->getTable() !== 'users') {
                    $builder->where('clinica_id', $user->clinica_id);
                }
            }
        });
    }
}