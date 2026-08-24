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
class SolicitudCiudadanaSupervisorRequest extends FormRequest
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
        
        $rule =  [
            'solicitante' => 'required',
            'email' => [
                'required',
                'email:rfc,dns',
            ],
            'telefono' => 'required|numeric|digits:9',
            'descripcion' => 'required',
            'procedencia' => 'required'
        ];

        if($this->rut != ''){
            $rule['rut'] = new Rut(new ChileRut);
        }
        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {

        return [
            'solicitante.required' => 'El nombre del solicitante es obligatorio',
            'rut.required' => 'El RUT es obligatorio',
            'email.required' => 'El Email es obligatorio',
            'email.email' => 'El Email no tiene un formato válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.digits' => 'El teléfono debe tener 9 dígitos',
            'telefono.numeric' => 'El telefóno debe contener sólo números',
            'procedencia.required' => 'La procedencia es obligatoria',
            'descripcion.required' => 'La descripción de su requerimiento es obligatoria'
        ];
    }
}
