<?php

namespace App\Http\Requests;


use App\Models\Rendiciones;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Clase que permite validar formulario de Login
 */
class ObservacionRendicionRequest extends FormRequest
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
            'idrendicion' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $rendicion = Rendiciones::select("id")
                        ->where("id", "=", $value)
                        ->get();
    
                    if (count($rendicion) == 0) {
                        return $fail("El id de rendición no se encuentra registrado.");
                    }
                }
            ]
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
           
            'password.required' => 'El idrendicion es requerido',
            'password.integer' => 'El idrendicion debe ser un número'
        ];
    }
}
