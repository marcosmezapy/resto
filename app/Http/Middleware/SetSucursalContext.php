<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetSucursalContext
{
    public function handle(Request $request, Closure $next)
    {
        // Si no hay sesión de sucursal → redirigir
        if (!session('sucursal_id')) {
            return redirect()->route('seleccionar.sucursal');
        }

        return $next($request);
    }
}