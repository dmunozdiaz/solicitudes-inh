<?php

namespace App\Http\Controllers\Solicitudes;

use DB;
use Mail;
use App\Models\Upload;
use App\Models\UserPublic;

use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use App\Classes\ProcessMaker\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Mail\ConfirmarNuevaSolicitud;
use App\Models\SolicitudesCiudadanas;
use Illuminate\Support\Facades\Storage;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;
use App\Http\Requests\SolicitudCiudadanaRequest;

class SolicitudesCiudadanasController extends Controller
{
    use UtilsTrait;
    
    public function list()
    {
       

        $soli = TipSolicitudes::where('activo','=', true)->get();


        
        return view('solicitudes.solicitudesciudadanas.list')->with([
            'solicitudes' => $soli,
        ]);
    }


    public function store(SolicitudCiudadanaRequest $request)
    {
        $tSol = TipSolicitudes::where('id','=',  $request->idsolicitud)->first();

        if(is_null($tSol)){
            return response()->json([
                'success' => false]);
        }

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

       

        
        $aSendVariables = array();

        $aSendVariables['text_nombreSolicitante'] = Auth::user()->name.' '.Auth::user()->lastname;
        $aSendVariables['text_rut'] =  Auth::user()->rut.'-'.Auth::user()->dv;
        $aSendVariables['text_email'] = $request->email;
        $aSendVariables['text_telefono'] = $request->telefono;
        $aSendVariables['text_Observacion'] = $request->descripcion;
        $aSendVariables['Procedencia'] = 'Sitio Web';
        $fechaRegistro = date('d/m/Y H:i');
        $aSendVariables['fechaRegistro'] = $fechaRegistro;
        
        $oCase = $wspm->newCase($tSol->idsolicitud, $tSol->idtarea, array($aSendVariables));

        $filesUpload = $request->filesUpload;

        if(is_array($filesUpload)){
            foreach ($filesUpload as $file) {
                $fl = Upload::where('id', '=', $file)->first();
                $path = Storage::disk('local')->path('files/'.$fl->filename);
             
                $wspm->uplodadDocument($oCase->app_uid,$tSol->idfileupload, $tSol->idtarea, $fl->filename, $path);
            }
        }
        
        

        $solicitudes = new SolicitudesCiudadanas();
        $solicitudes->userpublic_id = Auth::user()->id;
        $solicitudes->app_uid = $oCase->app_uid;
        $solicitudes->app_number = $oCase->app_number;
        $solicitudes->estado = 1;
        $solicitudes->tiposolicitud_id = $request->idsolicitud;
        $solicitudes->email = $request->email;
        $solicitudes->telefono = $request->telefono;
        $solicitudes->descripcion = $request->descripcion;
        $solicitudes->solicitante = Auth::user()->name.' '.Auth::user()->lastname;
        $solicitudes->rut = Auth::user()->rut.'-'.Auth::user()->dv;
        $solicitudes->save();
        
        $wspm->executeTrigger($oCase->app_uid, $tSol->idtrigger1 );
        $wspm->executeTrigger($oCase->app_uid, $tSol->idtrigger2 );

        $wspm->ruteCase($oCase->app_uid, null);
       
        $details = [
            'appnumbre' => $oCase->app_number,
            'fecharegistro' => $fechaRegistro,
            'nombresolicitante' => Auth::user()->name.' '.Auth::user()->lastname,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'descripcion' => $request->descripcion,
            'procedencia' => 'Sitio Web',
            'tipsolicitud' => $tSol->nombresolicitud

        ];

        Mail::to($request->email)->send(new ConfirmarNuevaSolicitud($details));

        $userPublic = UserPublic::where('id','=',Auth::user()->id)->first();
        $userPublic->email =  $request->email;
        $userPublic->telefono = $request->telefono;
        $userPublic->save();

        return response()->json([
            'success' => true, 'numerosolicitud'=>$oCase->app_number]);

    
    }
}
