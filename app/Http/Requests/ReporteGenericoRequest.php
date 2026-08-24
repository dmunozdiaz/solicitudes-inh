<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


/**
 * Clase que permite validar formulario de Login
 */
class ReporteGenericoRequest extends FormRequest
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
            'direccion' => 'required_without_all:area,anio,proceso',
            'area' => 'required_without_all:direccion,anio,proceso',
            'anio' => 'required_without_all:direccion,area,proceso',
            'proceso' => 'required_without_all:direccion,area,anio',
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
           
            'direccion.required_without_all' => 'Para descargar el reporte, debe seleccionar al menos una Dirección, Área/Depto., Tipo Solicitud o Año.',
            'area.required_without_all' => 'Para descargar el reporte, debe seleccionar al menos una Dirección, Área/Depto., Tipo Solicitud o Año.',
            'anio.required_without_all' => 'Para descargar el reporte, debe seleccionar al menos una Dirección, Área/Depto., Tipo Solicitud o Año.',
            'proceso.required_without_all' => 'Para descargar el reporte, debe seleccionar al menos una Dirección, Área/Depto., Tipo Solicitud o Año.',

        ];
    }
}
