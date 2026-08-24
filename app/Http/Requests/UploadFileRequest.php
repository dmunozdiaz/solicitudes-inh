<?php

namespace App\Http\Requests;

use App\Rules\Rut;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Http\FormRequest;
use Malahierba\ChileRut\ChileRut;

/**
 * Clase que permite subida de archivos
 */
class UploadFileRequest extends FormRequest
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
            'name' => [
                'required',
            ],
            'files' => 'required|mimes:png,jpg,jpeg|max:1024'
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
             
            'password.required' => 'El Password es requerido',
            'password.string' => 'El Password debe ser un string',
            'g-recaptcha-response.required' => 'El Captcha es requerido',
        ];
    }
}
