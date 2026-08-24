<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use App\Providers\ClaveUnicaProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

     
    public function register()
    {
        if(env('HABILITAR_SSL')==true){
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootClaveUnicaSocialite();

        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }

    public function bootClaveUnicaSocialite() {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
                'claveunica',
                function ($app) use ($socialite) {
            $config = $app['config']['services.claveunica'];
            return $socialite->buildProvider(ClaveUnicaProvider::class, $config);
        }
        );

        $socialite->extend(
            'claveunicafuncionario',
            function ($app) use ($socialite) {
        $config = $app['config']['services.claveunicafuncionario'];
        return $socialite->buildProvider(ClaveUnicaFuncionarioProvider::class, $config);
    }
    );
    }
}
