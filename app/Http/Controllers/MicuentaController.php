<?php

namespace App\Http\Controllers;

use Cookie;
use Illuminate\Http\Request;
use Validator,
    Redirect,
    Response;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\User as User;
use App\Models\Passusers;
use App\Traits\UtilsTrait;

class MicuentaController extends Controller {

    use UtilsTrait;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    public function detalle(Request $request) {
        $activo = Auth::user();


        $menu = (object) [
                    'detalle' => true
        ];

        return view('micuenta.detalle', [
            'user' => $activo,

            'menu' => $menu
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cambiar(Request $request) {

        $activo = Auth::user();

        $menu = (object) [
                    'pass' => true
        ];

        return view('micuenta.pass', [
            'user' => $activo,
            'menu' => $menu
        ]);
    }

    /**
     *
     */
    public function forcepass(Request $request){

        $activo = Auth::user();

        $menu = (object) [
                    'pass' => true
        ];

        return view('micuenta.passupdate', [
            'user' => $activo,
            'menu' => $menu,
            'aniosession' => $request->session()->get('anio-session')
        ]);
    }

    public function changePass(Request $request) {

        $activo = Auth::user();

        $validator = Validator::make($request->all(), $this->rules($activo), array(), $this->customAttributes());

        if ($validator->fails()) {

            return redirect()->route('cambiar')
                            ->withErrors($validator)
                            ->withInput();
        }


        $user = User::find($activo->id);

       DB::transaction(function () use ($request, $user) {
            /* $wspm = $this->getProcessMakerWs();

            $pmUserParams['usr_new_pass'] = $request->password;
            $pmUserParams['usr_cnf_pass'] = $request->password;

            $oUserPM = $wspm->updateUser($user->uidpm, $pmUserParams);

            $payload = [
                'iss' => "auth-processmaker", // Issuer of the token
                'sub' => $user->email, // Subject of the token
                'pass' => $request->password,
                'iat' => time(),
                'exp' => time() + 60 * 300,
    
            ];
    
            $token = $this->encrypt_decrypt('encrypt', json_encode($payload));
            $user->tokenpm = $token;*/

            

            $password = bcrypt($request->password);

            $user->password = $password;
            $user->pass_created_at = Carbon::now();
            $user->save();
            $user->passes()->create(['password' => $password]);
        });

        return redirect()->route('cambiar')
                        ->with('success', 'Su contraseña ha sido modificada exitosamente.');
    }

    public function forcepasschange(Request $request) {
        $activo = Auth::user();

        $validator = Validator::make($request->all(), $this->rulesForce($activo), array(), $this->customAttributes());

        if ($validator->fails()) {
//            $this->failedAttempt();
            return redirect()->route('forcepass')
                            ->withErrors($validator)
                            ->withInput();
        }

//        $activo = Auth::user();

        $user = User::find($activo->id);

        DB::transaction(function () use ($request, $user) {

            $wspm = $this->getProcessMakerWs();

            $pmUserParams['usr_new_pass'] = $request->password;
            $pmUserParams['usr_cnf_pass'] = $request->password;

            $oUserPM = $wspm->updateUser($user->uidpm, $pmUserParams);
            
            $payload = [
                'iss' => "auth-processmaker", // Issuer of the token
                'sub' => $user->email, // Subject of the token
                'pass' => $request->password,
                'iat' => time(),
                'exp' => time() + 60 * 300,
    
            ];
    
            $token = $this->encrypt_decrypt('encrypt', json_encode($payload));
            $user->tokenpm = $token;
            
            $password = bcrypt($request->password);

            $user->password = $password;
            $user->pass_created_at = Carbon::now();
            $user->save();
            $user->passes()->create(['password' => $password]);
        });

        return redirect()->route('cambiar')
                        ->with('success', 'Su contraseña ha sido modificada exitosamente.');
    }

    private function rules($user) {
        $rules = [
            'password' => [
                'required',
                'alpha_num',
                'confirmed',
                function ($attribute, $value, $fail) use ($user) {
                    $passwords = DB::table('passusers')
                            ->where('uid', '=', $user->id)
                            ->get();

                    foreach ($passwords as $password) {
                        if (Hash::check($value, $password->password)) {
                            $fail('La contraseña ingresada ya ha sido utilizada anteriormente. Por favor ingrese una nueva contraseña.');
                        }
                    }
                },
                'min:' . config('app.pass_long'),
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                //'regex:/\d{' . ( (int)config('app.pass_min_num') - 1 ). ',}/', // must contain at least one digit,
                function ($attribute, $value, $fail) use ($user) {
                    $nums_array = [];

                    preg_match_all('/\d/', $value, $nums_array);

                    if(count($nums_array[0]) < 4){
                        $fail("El formato de contraseña es inválido.");
                    }
                }
            ],
            'curr-password' => 'required|password'
        ];

        return $rules;
    }

     private function rulesForce($user) {
        $rules = [
            'password' => [
                'required',
                'alpha_num',
                'confirmed',
                function ($attribute, $value, $fail) use ($user) {
                    $passwords = DB::table('passusers')
                            ->where('uid', '=', $user->id)
                            ->get();

                    foreach ($passwords as $password) {
                        if (Hash::check($value, $password->password)) {
                            $fail('La contraseña ingresada ya ha sido utilizada anteriormente. Por favor ingrese una nueva contraseña.');
                        }
                    }
                },
                'min:' . config('app.pass_long'),
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                //'regex:/\d{' .( (int)config('app.pass_min_num') - 1 ) . ',}/', // must contain at least one digit
                function ($attribute, $value, $fail) use ($user) {
                    $nums_array = [];

                    preg_match_all('/\d/', $value, $nums_array);

                    if(count($nums_array[0]) < 4){
                        $fail("El formato de contraseña es inválido.");
                    }
                }
            ]
        ];

        return $rules;
    }

    private function customAttributes() {
        $customAttributes = [
            'curr-password' => 'Contraseña Actual'
        ];

        return $customAttributes;
    }

}
