<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use Illuminate\Routing\Pipeline;
use Illuminate\Routing\Controller;
use App\Http\Requests\LoginRequest;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\User as Userpm;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\LoginResponse;

use App\Classes\ProcessMaker\ProcessMakerWs; 
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Actions\AttemptToAuthenticate;


use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class AuthAuthenticatedSessionController extends Controller
{

    use UtilsTrait;
    
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

  

    /**
     * Attempt to authenticate a new session.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        

        $user = new Userpm();
        $user->setUsername($request->email);
        $userSys = User::where('email','=',$request->email)->first();
        $user->setPmUsrUid($userSys->uidpm);

        $pmWs = new CoreWorkflow($user, $processMaker, $request->password);

        $payload = [
            'iss' => "auth-processmaker", // Issuer of the token
            'sub' => $request->email, // Subject of the token
            'pass' => $request->password,
            'iat' => time(),
            'exp' => time() + 60 * 300,

        ];

        $token = $this->encrypt_decrypt('encrypt', json_encode($payload));
        $userSys->tokenpm = $token;
        $userSys->access_token = $pmWs->token['access_token'];
        $userSys->refresh_token = $pmWs->token['refresh_token'];
        $userSys->expires_in = $pmWs->token['expires_in'];
        $userSys->save();
      
        return $this->loginPipeline($request)->then(function ($request) {
            return app(LoginResponse::class);
        });
    }

    /**
     * Get the authentication pipeline instance.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    
}
