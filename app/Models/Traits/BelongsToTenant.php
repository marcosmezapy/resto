<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // AUTO ASIGNAR tenant_id
        static::creating(function ($model) {

            if (app()->runningInConsole()) {
                return;
            }

            if (Auth::check()) {
                $user = Auth::user();

                if ($user && empty($model->tenant_id)) {
                    $model->tenant_id = $user->tenant_id;
                }
            }

        });

        // GLOBAL SCOPE
        static::addGlobalScope('tenant', function (Builder $builder) {

            try {

                if (app()->runningInConsole()) {
                    return;
                }

                if (!Auth::check()) {
                    return;
                }

                $user = Auth::user();

                if (!$user || !$user->tenant_id) {
                    return;
                }

                $builder->where(
                    $builder->getModel()->getTable() . '.tenant_id',
                    $user->tenant_id
                );

            } catch (\Throwable $e) {
                return;
            }
        });
    }
}