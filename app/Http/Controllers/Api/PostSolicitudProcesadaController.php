<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Upload;
use App\Models\UserPublic;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use App\Mail\RespuestaSolicitud;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Support\Facades\Storage;

class PostSolicitudProcesadaController extends Controller
{
    public function post(Request $request)
    {
       
        $solicitud = SolicitudesCiudadanas::where('app_uid','=',$request->app_uid)->first();

        $solicitud->respuesta_observacion = $request->observacion;
        $solicitud->respuesta_archivos = $request->archivos;
        $solicitud->estado = 2;
        $solicitud->save();

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
            'respuesta' => $request->observacion,

        ];

        Mail::to($solicitud->email)->send(new RespuestaSolicitud($details));

        
        return response()->json(['success'=>true]);
    }
}
