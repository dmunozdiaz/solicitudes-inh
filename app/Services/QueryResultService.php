<?php

namespace App\Services;

use App\Models\Archivos;
use Illuminate\Support\Str;
use App\Models\TiposArchivos;
use Illuminate\Support\Facades\Hash;
use Malahierba\ChileRut\ChileRut;

/**
 * Clase que permite formatear los resultados de  querys
 */
class QueryResultService
{
    /**
     * Formatea datos del usuario
     *
     * @param array $row
     * @return array
     */
    public static function usuario($row):array
    {
        $aRoles = [];
        foreach ($row['roles'] as $rol) {
            $aRoles[] = $rol->role_id;
        }

        $aGrupoPm = [];
       
        foreach ($row['grupospm'] as $rol) {
            $aGrupoPm[] = $rol->pmgrupo_id;
        }


        $gruposfuncionario = [];
        if(isset($row['gruposfuncionario'])==true){
            foreach ($row['gruposfuncionario'] as $rol) {
                $gruposfuncionario[] = $rol->pmgrupo_id;
            }
        }

        $aTipSol = [];
        foreach ($row['tipsolicitudes'] as $rol) {
            $aTipSol[] = $rol->tiposolicitud_id;
        }

        $direccion = [];
        if(isset($row['direccion'])==true){
            foreach ($row['direccion'] as $rol) {
                $direccion[] = $rol->direccion_id;
            }
        }
        

        
        return [
            'id_usuario' => $row['id'],
            'rut' => $row['rut'],
            'nombres' => $row['nombres'],
            'appaterno' => $row['apellidos'],
            'email' => $row['email'],
            'perfil' => implode(',', $aRoles),
            'grupospm' => implode(',', $aGrupoPm),
            'gruposfuncionario' => implode(',', $gruposfuncionario),
            'direccion' => implode(',', $direccion),
            'tiposolicitud' => implode(',', $aTipSol)
        ];
    }


    /**
     * Formatea datos de rendiciones
     *
     * @param array $row
     * @return array
     */
    public static function rendicion($row):array
    {
        $chilerut = new ChileRut;

        return [
            'idrendicion' => $row->idrendicion,
            'numero' => $row->numero,
            'categoria' => $row->categoria,
            'subcategoria' => $row->subcategoria,
            'numdocumento' => ($chilerut->check($row->numdocumento)==true ? number_format(substr($row->numdocumento, 0, -1) ,0 , ',',".").'-'.substr($row->numdocumento, -1) : $row->numdocumento),
            'numerodocumentopago' => $row->numdocumentopago,
            'monto' => '$'.number_format($row->monto,0 , ',',"."),
            'fechapago' => $row->fechapago,
            'observaciones' => Str::upper($row->observaciones),
            'respaldogasto' => self::geRespaldo($row->idrendicion, 1),
            'respaldopago' => self::geRespaldo($row->idrendicion, 2)
        ];
    }


    /**
     * Formatea datos de rendiciones
     *
     * @param array $row
     * @return array
     */
    public static function rendicionProveedores($row):array
    {
        $chilerut = new ChileRut;

        return [
            'fila' => $row->fila,
            'total' => '$'.number_format($row->total,0 , ',',"."),
            'recordid' => $row->recordid,
            'proveedor' =>($chilerut->check($row->proveedor)==true ? number_format(substr($row->proveedor, 0, -1) ,0 , ',',".").'-'.substr($row->proveedor, -1) : $row->proveedor) ,
           
        ];
    }

    /**
     * Formatea datos de rendiciones
     *
     * @param array $row
     * @return array
     */
    public static function rendicionProveedor($row):array
    {
        

        return [
            'idrendicion' => $row->idrendicion,
            'numero' => $row->numero,
            'numerodocumentopago' => $row->numdocumentopago,
            'numfolio' => $row->numfolio,
            
            'monto' => '$'.number_format($row->monto,0 , ',',"."),
            'fechapago' => $row->fechapago,
            'observaciones' =>  Str::upper($row->observaciones),
            'respaldogasto' => self::geRespaldo($row->idrendicion, 1),
            'respaldopago' => self::geRespaldo($row->idrendicion, 2)
        ];
    }


    private static function geRespaldo($idrendicion, $catarchivos)
    {
        $tipos = TiposArchivos::getIdTipoArchivoCategoria($catarchivos);
       
        $qa = Archivos::where('idrendicion', '=', $idrendicion)->whereIn('IDTIPOARCHIVO', $tipos)->get();
        $archivos = [];
       
        if ($qa->count() > 0) {
            foreach ($qa as $archivo) {
                $archivos[] = [
            'nombre' => $archivo->tipoarchivo->nombre,
            'remoto' => $archivo->url_documento != '' ? true : false ,
            'hash' => hash('sha256', $archivo->id.'-'.$archivo->created_at),
        ];
            }
        }

        return $archivos;
    }
}
