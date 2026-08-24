<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Rendiciones;

class AnioSession {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        

        if ($request->session()->exists('anio-session')==false ) {
           
            $request->session()->put('anio-session', Rendiciones::getAnio());
        }else{
            if(is_null($request->anio)==false){
                $request->session()->put('anio-session', $request->anio);
            }
        }

        return $next($request);
    }

}
