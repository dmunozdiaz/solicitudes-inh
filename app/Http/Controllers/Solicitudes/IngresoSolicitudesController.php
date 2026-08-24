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
use App\Http\Requests\BuscarRutRequest;
use Illuminate\Support\Facades\Storage;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;
use App\Http\Requests\SolicitudCiudadanaSupervisorRequest;

class IngresoSolicitudesController extends Controller
{
    use UtilsTrait;
    
    public function listadoSolicitudes()
    {
        $aTipSol = [];
       foreach (Auth::user()->tiposolicitud()->get() as $tipo) {
        $aTipSol[] = $tipo->tiposolicitud_id;
       }

     
        $soli = TipSolicitudes::whereIn('id',$aTipSol)->where('activo','=', true)->get();


        
        return view('solicitudes.ingresosolicitud.list')->with([
            'solicitudes' => $soli,
        ]);
    }


    public function store(SolicitudCiudadanaSupervisorRequest $request)
    {
        $tSol = TipSolicitudes::where('id','=',  $request->idsolicitud)->first();

        if(is_null($tSol)){
            return response()->json([
                'success' => false]);
        }

       

        $wspm = $this->getProcessMakerWs();
       

        
        $aSendVariables = array();
        $rut = str_replace(".","",$request->rut);
        $aSendVariables['text_nombreSolicitante'] = $request->solicitante;
        if($rut == ''){
            $rut = 'Rut no ingresado';
        }
        $aSendVariables['text_rut'] =  $rut;
        $aSendVariables['text_email'] = $request->email;
        $aSendVariables['text_telefono'] = $request->telefono;
        $aSendVariables['text_Observacion'] = $request->descripcion;
        $aSendVariables['Procedencia'] = $request->procedencia;
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
        if($request->rut != ''){
            $aRut = explode('-', $rut);

            $userPublic = UserPublic::where('rut','=',$aRut[0])->first();
            if(empty($userPublic)== true){
                $userPublic = new UserPublic();
                
                if (strpos($request->solicitante, " ")){
                    $nombre = explode(' ',$request->solicitante);
                    $userPublic->name = $nombre[0];
                    $userPublic->lastname = $nombre[1];
                }else{
                    $userPublic->name = $request->solicitante;
                    $userPublic->lastname = '';
                }
                
                
                $userPublic->rut = $aRut[0];
                $userPublic->dv = $aRut[1];
            
                $userPublic->email =  $request->email;
                $userPublic->telefono = $request->telefono;
                $userPublic->type = 'RUN';
                $userPublic->verificado = true;
                $userPublic->enabled = true;

                $userPublic->save();
            }else{
                $userPublic->email =  $request->email;
                $userPublic->telefono = $request->telefono;
                $userPublic->save();
            }
            $solicitudes->userpublic_id = $userPublic->id;
        }else{
            $solicitudes->userpublic_id = null;
        }

        
       
        $solicitudes->app_uid = $oCase->app_uid;
        $solicitudes->app_number = $oCase->app_number;
        $solicitudes->estado = 1;
        $solicitudes->tiposolicitud_id = $request->idsolicitud;
        $solicitudes->email = $request->email;
        $solicitudes->telefono = $request->telefono;
        $solicitudes->descripcion = $request->descripcion;
        $solicitudes->solicitante = $request->solicitante;
       
        $solicitudes->rut = $rut;
        $solicitudes->save();
        
        $wspm->executeTrigger($oCase->app_uid, $tSol->idtrigger1 );
        $wspm->executeTrigger($oCase->app_uid, $tSol->idtrigger2 );

        $wspm->ruteCase($oCase->app_uid, null);
        
        $details = [
            'appnumbre' => $oCase->app_number,
            'fecharegistro' => $fechaRegistro,
            'nombresolicitante' => $request->solicitante,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'descripcion' => $request->descripcion,
            'procedencia' => $request->procedencia,
            'tipsolicitud' => $tSol->nombresolicitud

        ];

        Mail::to($request->email)->send(new ConfirmarNuevaSolicitud($details));

       

        return response()->json([
            'success' => true, 'numerosolicitud'=>$oCase->app_number]);

    
    }

    public function buscarRut(BuscarRutRequest $rq){
        $aRut = explode('-',str_replace(".","",$rq->rut));
        $user = UserPublic::select('email','telefono')->where('rut','=',$aRut[0])->first();

        return response()->json([
            'success' => true, 'user'=>$user ]);
    }
}
