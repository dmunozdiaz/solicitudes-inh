<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
          
            if (Auth::guard($guard)->check() && $guard == 'userspublic') {
                return redirect('https://inh.cl//home/solicitudes');
            }else if(Auth::guard($guard)->check() && $guard == 'web'){
                return redirect('https://inh.cl//home/mistareas');
            }else if(Auth::guard('userspublic')->check() == true ){
                return redirect('https://inh.cl//home/solicitudes');
            }else if (Auth::guard('web')->check() == true ) {
                return redirect('https://inh.cl//home/solicitudes');
            }
        }

        return $next($request);
    }
}
