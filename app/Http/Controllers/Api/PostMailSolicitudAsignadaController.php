<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests;
use App\Models\Upload;
use App\Models\UserPublic;
use App\Models\PmgrupoUser;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use App\Mail\SolicitudAsignada;
use App\Mail\RespuestaSolicitud;
use App\Mail\SolicitudEnProceso;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Support\Facades\Storage;
use App\Models\HistorialSolicitudesCiudadanas;

class PostMailSolicitudAsignadaController extends Controller
{
    public function post(Request $request)
    {  
        $solicitud = SolicitudesCiudadanas::where('app_uid','=',$request->app_uid)->first();
     
    
        $tSol = TipSolicitudes::where('id','=',  $solicitud->tiposolicitud_id)->first();
       
       // $user = UserPublic::where('id','=',$solicitud->userpublic_id)->first();
       
        $details = [
            'appnumbre' => $solicitud->app_number,
            'fecharegistro' => $solicitud->created_at,
            'nombresolicitante' => $solicitud->solicitante,
            'email' => $solicitud->email,
            'telefono' => $solicitud->telefono,
            'descripcion' => $solicitud->descripcion,
            'tipsolicitud' => $tSol->nombresolicitud,
            'fecha_asignacion' => date('d/m/Y H:i')

        ];
        
       $historial = new HistorialSolicitudesCiudadanas();
       $historial->id_solicitudes = $solicitud->id;
       $historial->estado = $request->etapa;
       $historial->descripcion = $request->descripcion;
       $historial->save();
            
            $fun = User::where('uidpm','=',$request->user_id)->first();

            Mail::to($fun->email)->send(new SolicitudAsignada($details));

            $details['estado'] = $request->etapa;
            $details['comentarios'] = $request->descripcion;
            Mail::to($solicitud->email)->send(new SolicitudEnProceso($details));
            

        
        return response()->json(['success'=>true]);
    }
}
