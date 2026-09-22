<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Cookie;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Token;
use App\Models\UserPublic;
use App\Traits\CarbonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


class ClaveUnicaController extends Controller
{

    use CarbonTrait;
    
    public function redirectToProvider()
    {
       
        return Socialite::with('claveunica')->scopes(['openid', 'run', 'name'])->redirect();
    }

    

    public function handleProviderCallback()
    {

        $userSocialite = Socialite::with('claveunica')->stateless()->user();

        if( $userSocialite == false){
            return redirect('/', 302);
        }

        $user = $this->getUser($userSocialite);
        $token = $this->getToken($userSocialite, $user);

        return $this->authAndRedirect(
            $token,
            $user
        ); // Login y redirección
    }

    /**
     * @param App\Models\User
     */
    private function authAndRedirect(\App\Models\Token $token, \App\Models\UserPublic $user)
    {
        
        Auth::guard('userspublic')->login($user);
       
        return redirect('/solicitudes-ciudadanas', 302)->with('status1','alert');
    }

    /**
     * @param Laravel\Socialite\Two\User $userAuth
     * @return App\Models\User
     */
    private function getUser(\Laravel\Socialite\Two\User $userAuth): \App\Models\UserPublic
    {

        $user = UserPublic::where('rut', '=', $userAuth->run)->first();

        if (is_null($user) === true) {
            $user = new UserPublic();
            $user->rut = $userAuth->run;
            $user->dv = $userAuth->dv;
            //$user->email = $userAuth->email;
            $user->name = $userAuth->first_name;
            $user->lastname = $userAuth->last_name;
            $user->type = $userAuth->tipo;
            $user->verificado = true;
            $user->save();
        }else{
            $user->rut = $userAuth->run;
            $user->dv = $userAuth->dv;
            //$user->email = $userAuth->email;
            $user->name = $userAuth->first_name;
            $user->lastname = $userAuth->last_name;
            $user->type = $userAuth->tipo;
            $user->verificado = true;
            $user->save();    
        }

        return $user;

    }

    /**
     * @param Laravel\Socialite\Two\User $userAuth
     * @param App\Models\UserPublic $user
     * @return App\Models\Token
     */
    private function getToken(\Laravel\Socialite\Two\User $userAuth, \App\Models\UserPublic $user): \App\Models\Token
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
        return redirect(env('APP_URL'));
    }


}
