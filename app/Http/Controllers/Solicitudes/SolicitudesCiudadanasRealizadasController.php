<?php

namespace App\Http\Controllers\Solicitudes;

use DB;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\SolicitudesCiudadanas;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerWs; 
use App\Models\HistorialSolicitudesCiudadanas;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

class SolicitudesCiudadanasRealizadasController extends Controller{
    
    public function list() {

        $soli = SolicitudesCiudadanas::where('userpublic_id','=',Auth::user()->id)->orderByDesc('created_at')->get();

       
        return view('solicitudes.solicitudesciudadanas.realizadas')->with([
            'solicitudes' => $soli,
        ]);
    }


    public function get(Request $resquest) {

        $soli = SolicitudesCiudadanas::where('id','=',$resquest->idsolicitud)->first();
        
        $tipsoli = TipSolicitudes::where('id','=',$soli->tiposolicitud_id)->first();
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

            
        
        $userpm = new Userpm();
        $userpm->setUsername(env('PM_USERNAME_PUBLIC'));
           
        $userpm->setPmUsrUid(env('PM_USR_UID_PUBLIC'));

        $pmWs = new CoreWorkflow($userpm, $processMaker, env('PM_PASSWORD_PUBLIC'));

        $wspm = new ProcessMakerWs($processMaker, $userpm, $pmWs->token);
        $documentos = $wspm->outputAppDocument($soli->app_uid);
       //dd($documentos['response']);
      
        $historial = HistorialSolicitudesCiudadanas::where('id_solicitudes','=',$resquest->idsolicitud)->orderBy('id','asc')->get();
  
        return view('solicitudes.solicitudesciudadanas.historicosolicitud')->with([
            "solicitud" => $soli,
            'documentos' => $documentos['response']->documents,
            "documentos_respuesta" => json_decode($soli->respuesta_archivos),
            "tipsoli" => $tipsoli,
            'historial' => $historial,
        ]);
    }

    

}