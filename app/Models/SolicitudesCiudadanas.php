<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SolicitudesCiudadanas extends Model{
    protected $table = 'solicitudes_ciudadanas';

   static public function tiempoPromedio($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }


       return  DB::select("
            SELECT
            (  AVG(TIMESTAMPDIFF(SECOND, primera, segunda) ))/(24*60*60) as tiempopromedio FROM
    (
        SELECT
            solicitudes_ciudadanas.id,
            created_at AS primera
        FROM
            solicitudes_ciudadanas
        WHERE
            solicitudes_ciudadanas.tiposolicitud_id IN
            (
               ".$sWhere." )
               AND solicitudes_ciudadanas.deleted_at is null   ) ini
LEFT JOIN
    (
        SELECT
            id,
            CASE
                WHEN estado = 2
                THEN cierre
                WHEN estado = 3
                THEN proceso
            END AS segunda
        FROM
            (
                SELECT
                    solicitudes_ciudadanas.id,
                    solicitudes_ciudadanas.estado,
                    solicitudes_ciudadanas.updated_at AS cierre
                FROM
                    solicitudes_ciudadanas
                WHERE
                    solicitudes_ciudadanas.tiposolicitud_id IN
                    (
                        ".$sWhere." )
                        AND solicitudes_ciudadanas.deleted_at is null    ) ini
        LEFT JOIN
            (
                SELECT
                    historial_solicitudes_ciudadanas.id_solicitudes,
                    historial_solicitudes_ciudadanas.created_at AS proceso
                FROM
                    historial_solicitudes_ciudadanas
                WHERE
                    historial_solicitudes_ciudadanas.id IN
                    (
                        SELECT
                            MIN( id )
                        FROM
                            historial_solicitudes_ciudadanas
                        GROUP BY
                            id_solicitudes)) fin
        ON
            (
                ini.id = fin.id_solicitudes) ) fin
ON
    (
        ini.id = fin.id)
        WHERE primera is not null AND segunda  is not null"
        );

       
       
       
    }

    static public function tiempoMaximoRespuesta($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }
    
       return  DB::select("
       SELECT
       (MAX(TIMESTAMPDIFF(SECOND, primera, segunda)) )/(24*60*60) as tiempomaximorespuesta  FROM
        (
            SELECT
                solicitudes_ciudadanas.id,
                created_at AS primera
            FROM
                solicitudes_ciudadanas
            WHERE
                solicitudes_ciudadanas.tiposolicitud_id IN
                (
                    ".$sWhere ." )
                    AND solicitudes_ciudadanas.deleted_at is null   ) ini
    LEFT JOIN
        (
            SELECT
                id,
                CASE
                    WHEN estado = 2
                    THEN cierre
                    WHEN estado = 3
                    THEN proceso
                END AS segunda
            FROM
                (
                    SELECT
                        solicitudes_ciudadanas.id,
                        solicitudes_ciudadanas.estado,
                        solicitudes_ciudadanas.updated_at AS cierre
                    FROM
                        solicitudes_ciudadanas
                    WHERE
                        solicitudes_ciudadanas.tiposolicitud_id IN
                        (
                            ".$sWhere .")
                            AND solicitudes_ciudadanas.deleted_at is null   ) ini
            LEFT JOIN
                (
                    SELECT
                        historial_solicitudes_ciudadanas.id_solicitudes,
                        historial_solicitudes_ciudadanas.created_at AS proceso
                    FROM
                        historial_solicitudes_ciudadanas
                    WHERE
                        historial_solicitudes_ciudadanas.id IN
                        (
                            SELECT
                                MIN( id )
                            FROM
                                historial_solicitudes_ciudadanas
                            GROUP BY
                                id_solicitudes)) fin
            ON
                (
                    ini.id = fin.id_solicitudes) ) fin
    ON
        (
            ini.id = fin.id)
            WHERE primera is not null AND segunda  is not null"
        );

       
       
       
    }

    static public function tiempoPromedioEnProceso($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }

        
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }

      /* return  DB::select("
       SELECT
       (AVG(TIMESTAMPDIFF(SECOND,proceso , cierre ) ) )/(24*60*60) as tiempopromedioenproceso
       
   FROM
       (
           SELECT
               solicitudes_ciudadanas.id,
               solicitudes_ciudadanas.estado,
               solicitudes_ciudadanas.updated_at AS cierre
           FROM
               solicitudes_ciudadanas
           WHERE
           solicitudes_ciudadanas.estado =  2
           AND solicitudes_ciudadanas.deleted_at is null
               AND solicitudes_ciudadanas.tiposolicitud_id IN
               (
                   ".$sWhere .")) ini
   LEFT JOIN
       (
           SELECT
               historial_solicitudes_ciudadanas.id_solicitudes,
               historial_solicitudes_ciudadanas.created_at AS proceso
           FROM
               historial_solicitudes_ciudadanas
           WHERE
               historial_solicitudes_ciudadanas.id IN
               (
                   SELECT
                       MIN( id )
                   FROM
                       historial_solicitudes_ciudadanas
                   GROUP BY
                       id_solicitudes)) fin
   ON
       (
           ini.id = fin.id_solicitudes)
      WHERE cierre is not null AND proceso  is not null "
        );*/

       return  DB::select("
       SELECT
        SUM( TIMESTAMPDIFF(SECOND,proceso , cierre ) ) / 
    (   SELECT 
            COUNT(*) 
        FROM
            solicitudes_ciudadanas
        WHERE
            solicitudes_ciudadanas.estado = 2
        AND solicitudes_ciudadanas.deleted_at IS NULL
        AND solicitudes_ciudadanas.tiposolicitud_id IN
            (    ".$sWhere .") ) /(24*60*60) tiempopromedioenproceso  
   FROM
       (
           SELECT
               solicitudes_ciudadanas.id,
               solicitudes_ciudadanas.estado,
               solicitudes_ciudadanas.updated_at AS cierre
           FROM
               solicitudes_ciudadanas
           WHERE
           solicitudes_ciudadanas.estado =  2
           AND solicitudes_ciudadanas.deleted_at is null
               AND solicitudes_ciudadanas.tiposolicitud_id IN
               (
                   ".$sWhere .")) ini
   LEFT JOIN
       (
           SELECT
               historial_solicitudes_ciudadanas.id_solicitudes,
               historial_solicitudes_ciudadanas.created_at AS proceso
           FROM
               historial_solicitudes_ciudadanas
           WHERE
               historial_solicitudes_ciudadanas.id IN
               (
                   SELECT
                       MIN( id )
                   FROM
                       historial_solicitudes_ciudadanas
                   GROUP BY
                       id_solicitudes)) fin
   ON
       (
           ini.id = fin.id_solicitudes)
      WHERE cierre is not null AND proceso  is not null "
        );
       
       
    }

    static public function tiempoMaximoEnProceso($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }

       return  DB::select("
       SELECT
       ( MAX(TIMESTAMPDIFF(SECOND,proceso , cierre ) ))/(24*60*60) as tiempomaximoenproceso  
FROM
    (
        SELECT
            solicitudes_ciudadanas.id,
            solicitudes_ciudadanas.estado,
            solicitudes_ciudadanas.updated_at AS cierre
        FROM
            solicitudes_ciudadanas
        WHERE
        solicitudes_ciudadanas.estado =  2
        AND solicitudes_ciudadanas.deleted_at is null
        AND solicitudes_ciudadanas.tiposolicitud_id IN
            (
                ".$sWhere ." )) ini
LEFT JOIN
    (
        SELECT
            historial_solicitudes_ciudadanas.id_solicitudes,
            historial_solicitudes_ciudadanas.created_at AS proceso
        FROM
            historial_solicitudes_ciudadanas
        WHERE
            historial_solicitudes_ciudadanas.id IN
            (
                SELECT
                    MIN( id )
                FROM
                    historial_solicitudes_ciudadanas
                GROUP BY
                    id_solicitudes)) fin
ON
    (
        ini.id = fin.id_solicitudes)
   WHERE cierre is not null AND proceso  is not null "
        );

       
    }

    static public function tiempoPromedioTotalRespuesta($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }

       return  DB::select("
       SELECT
       (AVG(TIMESTAMPDIFF(SECOND, solicitudes_ciudadanas.created_at, solicitudes_ciudadanas.updated_at  ) ) )/(24*60*60) as tiempopromediototalrespuesta
FROM
    solicitudes_ciudadanas
WHERE
    solicitudes_ciudadanas.tiposolicitud_id IN
    (
        ".$sWhere." )
            AND solicitudes_ciudadanas.estado = 2 
            AND solicitudes_ciudadanas.deleted_at is null"
        );

       
    }

    static public function tiempoMaximoTotalRespuesta($idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }

       return  DB::select("
       SELECT
       (MAX(TIMESTAMPDIFF(SECOND, solicitudes_ciudadanas.created_at, solicitudes_ciudadanas.updated_at  ) ) )/(24*60*60) as tiempomaximototalrespuesta
FROM
    solicitudes_ciudadanas
WHERE
    solicitudes_ciudadanas.tiposolicitud_id IN
    (
        ".$sWhere." )
         AND solicitudes_ciudadanas.estado = 2
         AND solicitudes_ciudadanas.deleted_at is null"
        );

       
    }


    static public function graficoCantidadSolicitudes($iEstados, $idDireccion = null , $idSolicitud = null, $periodo = null)
    {
        $aFechas = explode(' aaaa ', $periodo);
        $aFecha1 = explode('aaaa', $aFechas[0]);
        $aFecha2 = explode('aaaa', $aFechas[1]);

        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }

     

        return DB::select("
        SELECT 
            count(id) as solicitudes
        FROM 
            solicitudes_ciudadanas
        WHERE estado = ".$iEstados."  
        AND solicitudes_ciudadanas.deleted_at is null
        AND solicitudes_ciudadanas.created_at  BETWEEN '".$aFecha1[2]."-".$aFecha1[1]."-".$aFecha1[0]."' and '".$aFecha2[2]."-".$aFecha2[1]."-".$aFecha2[0]."' 
        AND solicitudes_ciudadanas.tiposolicitud_id in (".$sWhere.") ; ");
    }


    static public function graficoSolPorMes($anio = 2022, $estados, $idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }
    
        return DB::select("
                SELECT
                COUNT(id) as solicitudes,
                DATE_FORMAT( created_at,'%m' ) as meses
            FROM
                solicitudes_ciudadanas
            WHERE
                DATE_FORMAT( created_at,'%Y' ) = '".$anio."'
            AND deleted_at IS NULL
            AND estado in (".$estados.")
            AND solicitudes_ciudadanas.tiposolicitud_id in (".$sWhere.") 
            GROUP BY
                DATE_FORMAT( created_at,'%m' )  ");
    }

    static public function graficoSolPorMesTerminadas($anio = 2022, $idDireccion = null , $idSolicitud = null)
    {
        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

        if(is_null($idSolicitud) == false){
            $sWhere = $idSolicitud;
        }
    
    
        return DB::select("
                SELECT
                COUNT(id) as solicitudes,
                DATE_FORMAT( updated_at,'%m' ) as meses
            FROM
                solicitudes_ciudadanas
            WHERE
                DATE_FORMAT( updated_at,'%Y' ) = '".$anio."'
            AND deleted_at IS NULL
            AND estado = 2
            AND solicitudes_ciudadanas.tiposolicitud_id in (".$sWhere.")
            GROUP BY   DATE_FORMAT( updated_at,'%m' ) ; ");
    }


    static public function graficoDemandaSoli($idDireccion = null, $periodo = null)
    {
        $aFechas = explode(' aaaa ', $periodo);
        $aFecha1 = explode('aaaa', $aFechas[0]);
        $aFecha2 = explode('aaaa', $aFechas[1]);

        if(is_null($idDireccion )){
            $aDirecciones = Auth::user()->direccionUser();
            $aDireccion = [];
            foreach ($aDirecciones as $dire) {
                $aDireccion[] = $dire->id;
            }
            $sdirecciones = implode(',', $aDireccion);
        }else{
            $sdirecciones = $idDireccion;
        }

        $listSoliUsuario = Auth::user()->tipossolictud();

        $aSolUsuario = [];
        $ssolicitudes= "";
        foreach ($listSoliUsuario as $list) {
            $aSolUsuario[]  = $list->id;
            $ssolicitudes = implode(',', $aSolUsuario);
        }
        $sWhere = "SELECT 
        tipsolicitudes.id 
    FROM 
        tipsolicitudes 
    WHERE 
        tipsolicitudes.id_direccion in ( ".$sdirecciones.")
        AND tipsolicitudes.id in (".$ssolicitudes.")";

      
    
    
        return DB::select("
            SELECT
            laravel_temuco.tipsolicitudes.abreviacion as x,
            laravel_temuco.tipsolicitudes.nombresolicitud as nombresolicitud,
            COUNT(laravel_temuco.solicitudes_ciudadanas.id ) AS y
        FROM
            laravel_temuco.solicitudes_ciudadanas
        INNER JOIN
            laravel_temuco.tipsolicitudes
        ON
            (
                laravel_temuco.solicitudes_ciudadanas.tiposolicitud_id = laravel_temuco.tipsolicitudes.id)
        WHERE
             solicitudes_ciudadanas.tiposolicitud_id in (".$sWhere.")   
             AND solicitudes_ciudadanas.created_at  BETWEEN '".$aFecha1[2]."-".$aFecha1[1]."-".$aFecha1[0]."' and '".$aFecha2[2]."-".$aFecha2[1]."-".$aFecha2[0]."'   
             AND solicitudes_ciudadanas.deleted_at is null   
        GROUP BY
            laravel_temuco.tipsolicitudes.abreviacion,
            laravel_temuco.tipsolicitudes.nombresolicitud
        ORDER BY 
            y DESC
        LIMIT 
            5 ;");
    }


    static public function anioSolicitudes()
    {
        
    
    
        return DB::select("
        SELECT 
        DATE_FORMAT(created_at,'%Y') as anio
    FROM 
        solicitudes_ciudadanas
    GROUP BY DATE_FORMAT(created_at,'%Y')
    ORDER BY DATE_FORMAT(created_at,'%Y')  ;");
    }
}