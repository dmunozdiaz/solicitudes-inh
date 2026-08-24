<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests;
use App\Models\Upload;
use App\Models\PmGroups;
use App\Models\UserPublic;
use App\Models\PmgrupoUser;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use App\Mail\NuevaSolicitudGrupo;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Support\Facades\Storage;

class PostMailNuevaSolictudController extends Controller
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
            'tipsolicitud' => $tSol->nombresolicitud

        ];
        
        $group = PmGroups::where('idpmgrupo','=',$request->idpmgrupo)->first();
        
        $pmusers = PmgrupoUser::where('pmgrupo_id','=',$group->id)->get();          
        foreach ($pmusers as $pmuser) {
            
            $fun = User::where('id','=',$pmuser->user_id)->first();

            Mail::to($fun->email)->send(new NuevaSolicitudGrupo($details));
        }

       

        
        return response()->json(['success'=>true]);
    }
}
