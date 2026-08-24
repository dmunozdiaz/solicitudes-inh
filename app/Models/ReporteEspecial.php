<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UtilsTrait;
use App\Models\TipSolicitudes;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReporteEspecial extends Model
{
    use SoftDeletes, UtilsTrait;
    
    
    protected $table = "reporte_especial";
    protected $primaryKey = "id";

    public function getReporte($user_id, $area, $solicitud, $anio, $estado)
    {
        $user = User::where('id', '=', $user_id)->first();
        
        $asoldirec = [];
        $asolarea = [];
        $direccionarea= [];
        if (is_null($area) == false) {
         $asoldirec =  DB::table('tipsolicitudes')
            ->select('solicitudes_ciudadanas.app_uid')
            ->join('solicitudes_ciudadanas', 'tipsolicitudes.id', '=', 'solicitudes_ciudadanas.tiposolicitud_id')
            ->where('tipsolicitudes.area','=',$area)
            ->groupBy('solicitudes_ciudadanas.app_uid')
            ->get();
       
        }else{
            $areas = User::select(
                "tipsolicitudes.area"
            )
                ->join("tiposolicitud_user", "users.id", "=", "tiposolicitud_user.user_id")
                ->join("tipsolicitudes", "tiposolicitud_user.tiposolicitud_id", "=", "tipsolicitudes.id")
                ->groupBy("tipsolicitudes.area")
                ->where("tiposolicitud_user.user_id", "=",$user_id)->get()->toArray();
            $areasAux = [];
           
            foreach ($areas as  $value) {
                $areasAux[] = $value['area'];
            }
            $asoldirec =  DB::table('tipsolicitudes')
            ->select('solicitudes_ciudadanas.app_uid')
            ->join('solicitudes_ciudadanas', 'tipsolicitudes.id', '=', 'solicitudes_ciudadanas.tiposolicitud_id')
            ->whereIn('tipsolicitudes.area',$areasAux)
            ->groupBy('solicitudes_ciudadanas.app_uid')
            ->get();
        }

       
       
        foreach ($asoldirec as $value) {
            $direccionareaAux[] = $value->app_uid;
        }

        $soliAux = [];
        if(is_null($solicitud)==true){
            $tipos = User::select(
                "tipsolicitudes.id",
                "tipsolicitudes.idsolicitud",
                "tipsolicitudes.nombresolicitud"
            )
                ->join("tiposolicitud_user", "users.id", "=", "tiposolicitud_user.user_id")
                ->join("tipsolicitudes", "tiposolicitud_user.tiposolicitud_id", "=", "tipsolicitudes.id")
                ->where("tiposolicitud_user.user_id", "=", $user_id)->get()->toArray();
                
                foreach ($tipos as  $value) {
                    $soliAux[] = $value['idsolicitud'];
                }    
        }else{
            $soliAux[] = $solicitud;
        }

    
        
        $param = ['process' =>  implode(",",$soliAux),
        'anio' => $anio,
        'direccionanio' => null ,
        'estado' => $estado];

        
        $wspm = $this->getProcessMakerWsUserParam($user);
        
        $reporte = $wspm->getReportGeneric($param);
        
        $rep = collect(json_decode(json_encode($reporte->generico), true));
       
      //  dd($rep->toArray());
     
      if(empty($direccionareaAux)==false){
            return $rep->whereInStrict('APP_UID', $direccionareaAux)->toArray();
      }
        
        return $rep->toArray();
    }
}
