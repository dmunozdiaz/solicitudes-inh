<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Cookie;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Token;
use App\Traits\UtilsTrait;
use App\Traits\CarbonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


class ClaveUnicaFuncionarioController extends Controller
{

    use CarbonTrait, UtilsTrait;
    
    public function redirectToProvider()
    {
        return Socialite::with('claveunicafuncionario')->scopes(['openid', 'run', 'name'])->redirect();
    }

    

    public function handleProviderCallback()
    {

        $userSocialite = Socialite::with('claveunicafuncionario')->stateless()->user();

        if( $userSocialite == false){
            return redirect('/municipalidad', 302);
        }

        $user = $this->getUser($userSocialite);

        if (is_null($user) === true || isset($user->id) === false ) {
           
            return redirect(env('CLAVEUNICA_URL_LOGOUT') . env('APP_URL').'/municipalidad?error=1');
           
        }
        
        $token = $this->getToken($userSocialite, $user);

        return $this->authAndRedirect(
            $token,
            $user
        ); // Login y redirección
    }

    /**
     * @param App\Models\User
     */
    private function authAndRedirect(\App\Models\Token $token, \App\Models\User $user)
    {
        
        Auth::login($user);
       
        return redirect('/mistareas', 302);
    }

    /**
     * @param Laravel\Socialite\Two\User $userAuth
     * @return App\Models\User
     */
    private function getUser(\Laravel\Socialite\Two\User $userAuth): \App\Models\User
    {

        $user = User::where('rut', '=', $userAuth->run)->first();

        if (is_null($user) === true) {
            $user = new User();
           
        }else{
            
            $pmUserParams = [
              
                'usr_firstname' => $userAuth->first_name,
                'usr_lastname' => $userAuth->last_name
            ];
    
           
            $wspm = $this->getProcessMakerWsPublic();
            $oUserPM = $wspm->updateUser($user->uidpm, $pmUserParams);

            $user->rut = $userAuth->run;
            $user->dv = $userAuth->dv;
            //$user->email = $userAuth->email;
            $user->nombres = $userAuth->first_name;
            $user->apellidos = $userAuth->last_name;
            $user->type = $userAuth->tipo;
           
            $user->save();    
        }

        return $user;

    }

    /**
     * @param Laravel\Socialite\Two\User $userAuth
     * @param App\Models\User $user
     * @return App\Models\Token
     */
    private function getToken(\Laravel\Socialite\Two\User $userAuth, \App\Models\User $user): \App\Models\Token
    {

        $token = new Token();
        $token->access_token = $userAuth->token;
        $token->refresh_token = $userAuth->refreshToken;
        $now = $this->getCurrentDate();
        $token->expires_in = $this->addMinutesToDate($now, (int)$token->expiresIn / 60);

        $token->user_id = $user->id;

        $token->save();

        return $token;
    }


    public function logout(Request $request) {
        $request->session()->invalidate();
        return redirect(env('CLAVEUNICA_URL_LOGOUT') . env('APP_URL').'/municipalidad');
    }


}
