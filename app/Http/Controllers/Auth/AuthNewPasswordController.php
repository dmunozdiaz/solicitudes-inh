<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\UtilsTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Responsable;
use Laravel\Fortify\Actions\CompletePasswordReset;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse;

use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerWs; 
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

class AuthNewPasswordController extends Controller
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
     * Show the new password view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\ResetPasswordViewResponse
     */
    public function create(Request $request): ResetPasswordViewResponse
    {
        
        return app(ResetPasswordViewResponse::class);
    }

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(Request $request): Responsable
    {
        $this->request = $request;

        $validatedData =$request->validate($this->rules());
           
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = $this->broker()->reset(
            $request->only(Fortify::email(), 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $this->resetPassword($user, $password);
            }
        );

       
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? app(PasswordResetResponse::class, ['status' => $status])
                    : app(FailedPasswordResetResponse::class, ['status' => $status]);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            Fortify::email() => 'required|email',
            'password' => [
                'required',
                'alpha_num',
                function ($attribute, $value, $fail) {

                    $user = User::where('email', '=', $this->request->email)->firstOrFail();
                    $passwords = DB::table('passusers')
                        ->where('uid', '=', $user->id)
                        ->get();

                    foreach ($passwords as $password) {
                        if (Hash::check($value, $password->password)) {
                            $fail('La contraseña ingresada ya ha sido utilizada anteriormente. Por favor ingrese una nueva contraseña.');
                        }
                    }
                },
                'confirmed',
                'min:' . config('app.pass_long'),
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                //'regex:/\d{' . ( (int)config('app.pass_min_num') - 1 ) . ',}/',
                function ($attribute, $value, $fail) {
                    $nums_array = [];

                    preg_match_all('/\d/', $value, $nums_array);

                    if(count($nums_array[0]) < 4){
                        $fail("El formato de contraseña es inválido.");
                    }
                }
            ],
            'password_confirmation' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        //$this->setUserPassword($user, $password);
       
        DB::transaction(function () use ($user, $password) {

            $processMaker = new ProcessMaker();
            $processMaker->setWorkspace(env('PM_WORKSPACE'));
            $processMaker->setClientId(env('PM_CLIENTE_ID'));
            $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
            $processMaker->setSkin(env('PM_SKIN'));
            $processMaker->setLanguage(env('PM_LANGUAGE'));
            $processMaker->setClientScope('');
            $processMaker->setFullUrl(env('PM_URL'));

            

            $userpm = new Userpm();
            $userpm->setUsername(env('PM_USERNAME'));
           
            $userpm->setPmUsrUid(env('PM_USR_UID'));

            $pmWs = new CoreWorkflow($userpm, $processMaker, env('PM_PASSWORD'));

            $wspm = new ProcessMakerWs($processMaker, $userpm, $pmWs->token);

            $pmUserParams['usr_new_pass'] = $password;
            $pmUserParams['usr_cnf_pass'] = $password;

            $oUserPM = $wspm->updateUser($user->uidpm, $pmUserParams);
            
            $payload = [
                'iss' => "auth-processmaker", // Issuer of the token
                'sub' => $user->email, // Subject of the token
                'pass' => $password,
                'iat' => time(),
                'exp' => time() + 60 * 300,
    
            ];
    
            $token = $this->encrypt_decrypt('encrypt', json_encode($payload));
            $user->tokenpm = $token;

            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->pass_created_at = Carbon::now();
            $user->save();
            $user->passes()->create(['password' => $user->password]);
        });

       

       // $this->guard()->login($user);

      //  $this->generaLog($user->name, request()->ip(), 'Recuperación de contraseña realizada', $user->name, Carbon::now());

        return redirect()->to('/');
    }
}
