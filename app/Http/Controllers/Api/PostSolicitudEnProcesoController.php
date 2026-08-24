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

class PostSolicitudEnProcesoController extends Controller
{
    public function post(Request $request)
    {
       
        $solicitud = SolicitudesCiudadanas::where('app_uid','=',$request->app_uid)->first();

        $solicitud->respuesta_observacion = $request->observacion;
        $solicitud->respuesta_archivos = $request->archivos;
        $solicitud->estado = 3;
        $solicitud->save();

        
        return response()->json(['success'=>true]);
    }
}
