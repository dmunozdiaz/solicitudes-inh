<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UtilsTrait;
use App\Models\TipSolicitudes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReporteGeneral extends Model
{
    use SoftDeletes, UtilsTrait;
    
    
    protected $table = "reporte_general";
    protected $primaryKey = "id";

    
    public function getReporte($user_id, $direccion, $area, $solicitud, $anio, $estado)
    {
        $asoldirec = [];
        $asolarea = [];
        $direccionarea= [];
        if (is_null($direccion) == false && is_null($area) == false) {

            $asoldirec =  DB::table('tipsolicitudes')
            ->select('solicitudes_ciudadanas.app_uid')
            ->join('solicitudes_ciudadanas', 'tipsolicitudes.id', '=', 'solicitudes_ciudadanas.tiposolicitud_id')
            ->where([['tipsolicitudes.direccion','=',$direccion],['tipsolicitudes.area','=',$area]])
            ->groupBy('solicitudes_ciudadanas.app_uid')
            ->get();

            
        }else if (is_null($direccion) == false) {

            $asoldirec =  DB::table('tipsolicitudes')
            ->select('solicitudes_ciudadanas.app_uid')
            ->join('solicitudes_ciudadanas', 'tipsolicitudes.id', '=', 'solicitudes_ciudadanas.tiposolicitud_id')
            ->where('tipsolicitudes.direccion','=',$direccion)
            ->groupBy('solicitudes_ciudadanas.app_uid')
            ->get();

            
        }else if (is_null($area) == false) {

            $asoldirec =  DB::table('tipsolicitudes')
            ->select('solicitudes_ciudadanas.app_uid')
            ->join('solicitudes_ciudadanas', 'tipsolicitudes.id', '=', 'solicitudes_ciudadanas.tiposolicitud_id')
            ->where('tipsolicitudes.area','=',$area)
            ->groupBy('solicitudes_ciudadanas.app_uid')
            ->get();
       
        }

       
       
        foreach ($asoldirec as $value) {
            $direccionareaAux[] = $value->app_uid;
        }

    
        
        $param = ['process' =>  $solicitud,
        'anio' => $anio,
        'direccionanio' => null ,
        'estado' => $estado];

        $user = User::where('id', '=', $user_id)->first();
        $wspm = $this->getProcessMakerWsUserParam($user);
        
        $reporte = $wspm->getReportGeneric($param);
       // Log::error(json_encode($reporte->generico));
        $rep = collect(json_decode(json_encode($reporte->generico), true));
       
        if(empty($direccionareaAux)==false){
            return $rep->whereInStrict('APP_UID', $direccionareaAux)->toArray();
        }
        return $rep->toArray();
    }
}
