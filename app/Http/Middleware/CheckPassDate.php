<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;

class CheckPassDate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

       
        
        $user = $request->user();
        $to = Carbon::createFromFormat('Y-m-d H:s:i', Carbon::now());
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $user->pass_created_at);
        $diff_in_days = $to->diffInDays($from);

        if ($diff_in_days > config('app.dias_pass')) {
            $errors = new MessageBag(['password' => ['Su contraseña ha expirado. Debe cambiar su contraseña para seguir usando el sistema.']]);
            
     //        auth()->logout();
            return redirect()->route('forcepass')->withErrors($errors)->withInput();
        }

        return $next($request);
    }

}
