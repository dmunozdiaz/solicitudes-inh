<?php
namespace App\Providers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class ClaveUnicaFuncionarioProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(env('CLAVEUNICA_AUTHORIZATION_URL'), $state);
    }

    /**
     * Retorna Url para obtener token
     * el valor de CLAVEUNICA_ACCESS_TOKEN_URL se configura en el .env
     */
    protected function getTokenUrl()
    {
        return env('CLAVEUNICA_ACCESS_TOKEN_URL');
    }

    /**
     * Obtener la respuesta del token de acceso para el codigo
     *
     * @param  string  $code
     * @return array
     */
    public function getAccessTokenResponse($code)
    {
        try {

            $response = $this->getHttpClient()->post($this->getTokenUrl(), [
                'headers' => ['Accept' => 'application/json'],
                'form_params' => $this->getTokenFields($code),
            ]);
        } catch (ClientException $e) {

            return false;
           
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException;
        }

        $response = $this->getAccessTokenResponse($this->getCode());
       
        if ($response == false) {
            return false;
        }

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = Arr::get($response, 'access_token')
        ));

        return $user->setToken($token)
            ->setRefreshToken(Arr::get($response, 'refresh_token'))
            ->setExpiresIn(Arr::get($response, 'expires_in'));
        

    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return Arr::add(
            parent::getTokenFields($code), 'grant_type', 'authorization_code'
        );
    }

    /**
     * Obtiene la información del usuario autenticado con clave unica
     * el valor de CLAVEUNICA_USER_INFO_URL se obtiene desde archivo .env
     */
    protected function getUserByToken($token)
    {
        try {
            $response = $this->getHttpClient()->post(env('CLAVEUNICA_USER_INFO_URL'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
        } catch (ClientException $e) {

            return false;
            
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['RolUnico']['numero'],
            'first_name' => implode(' ', $user['name']['nombres']),
            'last_name' => implode(' ', $user['name']['apellidos']),
            'run' => $user['RolUnico']['numero'],
            'dv' => $user['RolUnico']['DV'],
            'tipo' => $user['RolUnico']['tipo']
        ]);
    }
}
