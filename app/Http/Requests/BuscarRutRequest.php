<?php

namespace App\Http\Requests;

use App\Rules\Rut;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Http\FormRequest;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;


/**
 * Clase que permite validar formulario de solicitud ciudadana
 */
class BuscarRutRequest extends FormRequest
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
           
            'rut' => ['required', new Rut(new ChileRut)]
            
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
            
            'rut.required' => 'El RUT es obligatorio',
        ];
    }
}
