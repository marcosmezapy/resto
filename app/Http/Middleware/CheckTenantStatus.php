<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTenantStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $tenant = Auth::user()->tenant;

        // 🚫 Si no tiene tenant
        if (!$tenant) {
            abort(403, 'Sin tenant asignado');
        }

        // 🚫 Suspendido
        if ($tenant->estado === 'suspendido') {
            Auth::logout();
            return redirect('/login')->withErrors('Cuenta suspendida');
        }

        // 🚫 Vencido
        if ($tenant->fecha_vencimiento && $tenant->fecha_vencimiento < now()) {
            Auth::logout();
            return redirect('/login')->withErrors('Suscripción vencida');
        }

        return $next($request);
    }
}