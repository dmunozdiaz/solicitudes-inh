<?php

namespace App\Http\Requests;

use App\Rules\Rut;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Http\FormRequest;
use Malahierba\ChileRut\ChileRut;

/**
 * Clase que permite validar formulario de Login
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Fortify::username() => [
                'required',
                'email:rfc,dns',
            ],
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
             Fortify::username().'.required' => 'El Email es obligatorio',
             Fortify::username().'.email' => 'El Email no tiene un formato válido',
            'password.required' => 'La Contraseña es requerida',
            'password.string' => 'La Contraseña debe ser un string',
            'g-recaptcha-response.required' => 'El Captcha es requerido',
        ];
    }
}
