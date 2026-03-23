<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\CajaSesion;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

  public function boot ()
    {
        View::composer('*', function ($view) {

            $cajaAbierta = null;

            if (Auth::check()) {
                $cajaAbierta = CajaSesion::where('usuario_id', Auth::id())
                    ->where('estado', 'abierta')
                    ->first();
            }

            $view->with('cajaAbierta', $cajaAbierta);
        });
    }

}
