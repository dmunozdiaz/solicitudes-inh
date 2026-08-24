<?php

namespace App\Services\Validator;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Validator;
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;

class UsuarioValidatorServices
{
    public static function validarAgregarUsuario($data)
    {

        $bValidaTipSolicitud = false;
        $bValidaFuncionario = false;
        $bValidaRecepcion = false;
        $bValidaDireccion = false;
        if(isset($data['add-perfil'])){
            if( in_array(2, $data['add-perfil'])== true || in_array(3, $data['add-perfil'])== true || in_array(4, $data['add-perfil'])== true ){
                $bValidaDireccion = true;
            }

            if(in_array(2, $data['add-perfil'])== true && isset($data['add-direccion']) == true ){
                $bValidaTipSolicitud = true; 
               
            }

            if(in_array(3, $data['add-perfil'])== true && isset($data['add-direccion']) == true){
                $bValidaFuncionario = true; 
            }

            if(in_array(4, $data['add-perfil'])== true && isset($data['add-direccion']) == true){
                $bValidaRecepcion = true; 
            }
        }
        

        $rules = [
            'add-rut' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $aRut = explode('-', $value);
                    $rut = str_replace('.', '', $aRut[0]);

                    $check_rut = User::select("id")
                    ->where("rut", "=", $rut)
                    ->get();

                    if (count($check_rut) > 0) {
                        return $fail("Ya se encuentra utilizado el usuario detallado.");
                    }
                    if (Rut::parse($value)->validate() == false) {
                        return $fail("El <strong>:attribute</strong> no es válido.");
                    }
                }],
            'add-nombre' => 'required',
            'add-appaterno' => 'required',
           
            'add-email' => [
                'required',
                'email:rfc,dns',
                function ($attribute, $value, $fail) use ($data) {
                    $check_rut = User::select("id")
                        ->where("email", "=", $value)
                        ->get();
    
                    if (count($check_rut) > 0) {
                        return $fail("Ya se encuentra registrado un usuario con ese email.");
                    }
                }
            ],
            'add-perfil' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $check = Role::select("id")
                    ->where("id", "=", $value)
                    ->get();

                    if (count($check) == 0) {
                        return $fail("El Perfil ingresado no existe.");
                    }
                }
            ],
            'add-tiposolicitud' =>  Rule::requiredIf($bValidaTipSolicitud),
            'add-direccionfuncionario' =>  Rule::requiredIf($bValidaFuncionario),
            'add-grupopm' =>  Rule::requiredIf($bValidaRecepcion),
            'add-direccion' =>  Rule::requiredIf($bValidaDireccion)
            
        ];

      

        $customMsg = self::getCustomMsg();

        $atributos = [
            'add-rut' =>  'Rut',
            'add-nombre' => 'Nombre',
            'add-appaterno' => 'Apellido Paterno',
            'add-apmaterno' => 'Apellido Materno',
            'add-email' => 'Correo Electrónico',
            'add-perfil' => 'Perfil',
            'add-direccion' => 'Dirección',
            'add-grupopm' => 'Encargados de Recepción',
            'add-tiposolicitud' => 'Solicitudes a Supervisar',
            'add-direccionfuncionario' => 'Solicitudes asignables para procesar'
        ];

        $validateData = Validator::make($data, $rules, $customMsg);

        $validateData->setAttributeNames($atributos);

        if ($validateData->fails()) {
            return $validateData->errors();
        } else {
            return false;
        }
    }

    public static function validarEditarUsuario($data)
    {
        $bValidaTipSolicitud = false;

        $bValidaFuncionario = false;
        $bValidaDireccion = false;
        if( in_array(2, $data['edit-perfil'])== true || in_array(3, $data['edit-perfil'])== true || in_array(4, $data['edit-perfil'])== true ){
            $bValidaDireccion = true;
        }

        if(isset($data['edit-perfil'])==true){
            if(in_array(2, $data['edit-perfil'])== true){
                $bValidaTipSolicitud = true; 
            }
        }
        
        if(isset($data['edit-perfil'])==true){
            if(in_array(3, $data['edit-perfil'])== true){
                $bValidaFuncionario = true; 
            }
        }

        $rules = [
            'id_usuario' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $check_rut = User::select("id")
                        ->where("id", "=", $value)
                        ->get();
    
                    if (count($check_rut) == 0) {
                        return $fail("El usuario no se encuentra registrado.");
                    }
                    
                }
            ],
            'edit-nombre' => 'required',
            'edit-appaterno' => 'required',
           
            'edit-email' => [
                'required',
                'email:rfc,dns',
                function ($attribute, $value, $fail) use ($data) {
                    $check_rut = User::select("id")
                        ->where([["email", "=", $value],['id','<>',$data['id_usuario']]])
                        ->get();
                    
                    if (count($check_rut) > 0)  {
                        return $fail("Ya se encuentra registrado un usuario con ese email.");
                    }
                }
            ],
            'edit-perfil' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $check = Role::select("id")
                    ->where("id", "=", $value)
                    ->get();

                    if (count($check) == 0) {
                        return $fail("El Perfil ingresado no existe.");
                    }
                }
            ],
            'edit-tiposolicitud' =>  Rule::requiredIf($bValidaTipSolicitud),
            'edit-direccionfuncionario' =>  Rule::requiredIf($bValidaFuncionario),
            'edit-direccion' =>  Rule::requiredIf($bValidaDireccion)
        ];

      

        $customMsg = self::getCustomMsg();

        $atributos = [
            'id_usuario' => 'Id de Usuario',
            'edit-nombre' => 'Nombre',
            'edit-appaterno' => 'Apellido Paterno',
            'edit-apmaterno' => 'Apellido Materno',
            'edit-email' => 'Correo Electrónico',
            'edit-perfil' => 'Perfil',
            'edit-direccion' => 'Dirección',
            'edit-tiposolicitud' => 'Solicitudes a Supervisar',
            'edit-direccionfuncionario' => 'Solicitudes asignables para procesar'
        ];

        $validateData = Validator::make($data, $rules, $customMsg);

        $validateData->setAttributeNames($atributos);

        if ($validateData->fails()) {
            return $validateData->errors();
        } else {
            return false;
        }
    }

    public static function validarPerfil($data)
    {
        $rules = [
            
            'perfil' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $check = Role::select("id")
                    ->where("id", "=", $value)
                    ->get();

                    if (count($check) == 0) {
                        return $fail("El Perfil ingresado no existe.");
                    }
                }
            ]
           
        ];

       

        $customMsg = self::getCustomMsg();

        $atributos = [
            
            'perfil' => 'Perfil'
        ];

        $validateData = Validator::make($data, $rules, $customMsg);

        $validateData->setAttributeNames($atributos);

        if ($validateData->fails()) {
            return $validateData->errors();
        } else {
            return false;
        }
    }

    public static function validarUsuario($data)
    {
        $rules = [
            
            'id_usuario' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $check_rut = User::select("id")
                        ->where("id", "=", $value)
                        ->get();
    
                    if (count($check_rut) == 0) {
                        return $fail("El usuario no se encuentra registrado.");
                    }
                    
                }
            ]
           
        ];

       

        $customMsg = self::getCustomMsg();

        $atributos = [
            
            'id_usuario' => 'Id de Usuario'
        ];

        $validateData = Validator::make($data, $rules, $customMsg);

        $validateData->setAttributeNames($atributos);

        if ($validateData->fails()) {
            return $validateData->errors();
        } else {
            return false;
        }
    }

    public static function getCustomMsg()
    {
        $aCustom = [
            'required' => 'El campo <strong>:attribute</strong> es requerido',
            'max' => [
                'string' => 'El campo <strong>:attribute</strong> supera el máximo de caracteres.',
            ],
            //'min' => 'Valor para <strong>:attribute</strong> no valido',
            'array' => 'El campo <strong>:attribute</strong> debe ser un arreglo.',
            'integer' => 'El campo <strong>:attribute</strong> debe ser entero.',
            'string' => 'El campo <strong>:attribute</strong> debe ser texto',
            'email' => 'El campo <strong>:attribute</strong> no tiene formato de Correo Electrónico',
            'date' => 'El campo <strong>:attribute</strong> debe ser una fecha.',
            'confirmed'=> 'La confirmación de <strong>:attribute</strong> no coincide.',
            'min' => 'El lago mínimo de <strong>:attribute</strong> no corresponde',
            'regex' => 'El formado de <strong>:attribute</strong> debe contener letras mayúsculas y minúsculas',
        ];

        return $aCustom;
    }
}
