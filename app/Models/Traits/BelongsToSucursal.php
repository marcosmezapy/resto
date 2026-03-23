<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToSucursal
{
    protected static function bootBelongsToSucursal()
    {
        static::creating(function ($model) {
            if (session()->has('sucursal_id')) {
                $model->sucursal_id = session('sucursal_id');
            }
        });

        static::addGlobalScope('sucursal', function (Builder $builder) {
            if (session()->has('sucursal_id')) {
                $builder->where('sucursal_id', session('sucursal_id'));
            }
        });
    }
}