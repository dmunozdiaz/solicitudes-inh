<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        
        if (! $request->expectsJson()) {
            if( Route::is('solicitudes-ciudadanas') ||  Route::is('agregar-solicitud-ciudadana') ||  Route::is('solicitudes-realizadas') || Route::is('get-solicitude-realizada') || Route::is('auth/claveunica/logout')  ){
                return route('home-publico');
            }
            return route('home-municipalidad');
        }
    }


}
