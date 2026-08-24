<?php

namespace App\Http\Controllers\Solicitudes;
use DB;
use Carbon\Carbon;
use App\Traits\UtilsTrait;
use App\Models\PmgrupoUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerWs; 
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

class MiTareaController extends Controller{
    
    use UtilsTrait;

    public function list() {
        $core = $this->getCoreWorkflow();
        $allPmProcess = $core->listAllProcess();
        $allPmTask= $core->listAllTaks();
      
        $url = \Route::current();

        $porhaceractivo = "";
        $portomaractivo = "";
        $ejecutadasactivo = "";
        $supervisoractivo = "";

        $configBandejasPaginas = array(
            "mistareas" => array(
                "por_hacer" => true,
                "por_tomar" => true,
                "ejecutadas" => true,
                "supervisor" => false
            ),
            "supervision" => array(
                "por_hacer" => false,
                "por_tomar" => false,
                "ejecutadas" => false,
                "supervisor" => true
            ) 
        );
        
        $conf = $configBandejasPaginas[$url->uri];

        if ($conf['por_tomar'] == true) {
            $portomaractivo = "active show";
        }else if ($conf['por_hacer'] == true) {
            $porhaceractivo = "active show";
        }   else if ($conf['ejecutadas'] == true) {
            $ejecutadasactivo = "active show";
        } else if ($conf['supervisor'] == true) {
            $supervisoractivo = "active show";
        }

        return view('solicitudes.mistareas.list')->with([
            "url" => $url->uri,
            "porhaceractivo" => $porhaceractivo,
            "portomaractivo" => $portomaractivo,
            "ejecutadasactivo" => $ejecutadasactivo,
            "supervisoractivo" => $supervisoractivo,
            "porhacer" => $conf['por_hacer'],
            "portomar" => $conf['por_tomar'],
            "ejecutadas" => $conf['ejecutadas'],
            "supervisor" => $conf['supervisor'],
            "allPmTipoTramite" => [],
            "allPmProcedencia" => [],
            "allPmComunas" => [],
            "allPmTask" => $allPmTask,
            "allPmUsers" => [],
            "allPmProcess" => $allPmProcess,
            "allPmProcessSupervisor" => Auth::user()->tipossolictud(),
            //"arrayData" => json_encode($this->listInbox()),
            "historicos" => $this->getHistoricoTarea()
        ]);
    }
    
    /**
     * Tareas por hacer
     */
    public function listInbox(Request $rq) {

        $aQuery = [];
        $aPaginacion = ["page" => "1", "perpage" => "10", "0" => ""];
        $aSort = [];

        if (empty($rq->process) === false) {
            $aQuery['process'] = urlencode($rq->process);
        }

        if (empty($rq->number) === false) {
            $aQuery['number'] = urlencode($rq->number);
        }

        if (empty($rq->nametask) === false) {
            $aQuery['nametask'] = urlencode($rq->nametask);
        }

        if (empty($rq->datefrom) === false) {
            $aQuery['datefrom'] = urlencode($rq->datefrom);
        }

        if (empty($rq->dateto) === false) {
            $aQuery['dateto'] = urlencode($rq->dateto);
        }

      
        if (empty($rq->rutsolicitante) === false) {
            $aQuery['rutsolicitante'] = urlencode($rq->rutsolicitante);
        }

        if (empty($rq->nombresolicitante) === false) {
            $aQuery['nombresolicitante'] = urlencode($rq->nombresolicitante);
        }
        
        $core = $this->getCoreWorkflow();

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

         $processMakerSoap = new ProcessMakerSoapWs($processMaker);
        
         if($processMakerSoap->bActivo==false){
            return [];
         }

       //  $userPm = json_decode($this->encrypt_decrypt('decrypt', Auth::user()->tokenpm));

         //$session = $processMakerSoap->login(Auth::user()->email, $userPm->pass, false);
         $session = $core->getSessionId();

        
        //$aPaginacion = $_POST['pagination'];

        //$aSort = $_POST['sort'];
        //$aQuery = $_POST['query'];

        if (count($aSort) == 0) {
            $aSort["field"] = "fdocumento,app_number";
            $aSort['sort'] = "asc,asc";
        }


        $params = array_merge((array) $aPaginacion, (array) $aSort, (array) $aQuery);
        

        $allPmList2 = $core->getReceivedList($params);

        $aReturn = [];
        $aReturn['meta'] = $allPmList2->meta;

        $aCases = [];
        $iCont = 0;

        foreach ($allPmList2->data as $case) {

            $aCases[$iCont]['app_uid'] = $case->APP_UID;
            $aCases[$iCont]['del_index'] = $case->DEL_INDEX;
            $aCases[$iCont]['app_number'] = $case->APP_NUMBER;
            $aCases[$iCont]['app_tas_title'] = $case->APP_TAS_TITLE;
            $aCases[$iCont]['tipo_solicitud'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['datos-solicitante'] = $case->TEXT_1.' - RUT: '.$case->TEXT_3.' - Tel: '.$case->TEXT_5.' - Email: '.$case->TEXT_4;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['tipo_documento'] = $case->TEXT_1;
            $aCases[$iCont]['fecha'] = date('d/m/Y', strtotime($case->DATETIME_2));
            $aCases[$iCont]['tipodocumento_fechadocumento'] = $case->TEXT_1." ".date('d/m/Y', strtotime($case->DATETIME_1));

            $date1 = new Carbon($case->DEL_TASK_DUE_DATE);
            $date2 = Carbon::now();
          
            $aCases[$iCont]['expire'] = true;
            if($date1->gt($date2)){
                $aCases[$iCont]['expire'] = false;
            }

            $aCases[$iCont]['del_task_due_date'] = date('d/m/Y H:i', strtotime($case->DEL_TASK_DUE_DATE));
            
         /*   $aCases[$iCont]['materia'] = $case->TEXT_3;
            $aCases[$iCont]['vinculada_a'] = $case->TEXT_4;
            $aCases[$iCont]['destinatarios'] = $case->TEXT_5;
            $aCases[$iCont]['previous_usr_firstname'] = $case->PREVIOUS_USR_FIRSTNAME.' '.$case->PREVIOUS_USR_LASTNAME;
            $aCases[$iCont]['app_create_date'] = date('d/m/Y H:i', strtotime($case->APP_CREATE_DATE));*/
            
            if (empty($case->DATETIME_1) === false && $case->DATETIME_1 != '0000-00-00 00:00:00') {
                $aCases[$iCont]['last_update'] = date('d/m/Y', strtotime($case->DATETIME_1));
            } else {
                $aCases[$iCont]['last_update'] = '';
            }

            $aCases[$iCont]['task'] = $case->APP_TAS_TITLE;
            $url =  "/historicosolicitud?caso=".$case->APP_UID;
            $aCases[$iCont]['urlhistorial'] = $url;
            $aCases[$iCont]['urliframe'] = env('PM_URL_FRONT'). 'sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&sid='.$session.'&action=todo';
            //$aCases[$iCont]['urlmapa'] = $processMaker->getFullUrl() . '/sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/designer?prj_uid=' . $case->APP_UID . '&prj_readonly=true&app_uid=' . $case->APP_UID;

            $aCases[$iCont]['action'] = '';
            $iCont++;
        }

        $aReturn['data'] = $aCases;
        $aReturn['recordsTotal'] = $allPmList2->meta->total;

        //dd($aReturn);
        
        return $aReturn;
    }

    /**
     * Tareas ejecutadas
     */
    public function listParticipated(Request $rq) {

        
        $aQuery = [];
        $aPaginacion = ["page" => "1", "perpage" => "10", "0" => ""];
        $aSort = [];

        if (empty($rq->process) === false) {
            $aQuery['process'] = urlencode($rq->process);
        }

        if (empty($rq->number) === false) {
            $aQuery['number'] = urlencode($rq->number);
        }

        if (empty($rq->nametask) === false) {
            $aQuery['nametask'] = urlencode($rq->nametask);
        }

        if (empty($rq->datefrom) === false) {
            $aQuery['datefrom'] = urlencode($rq->datefrom);
        }

        if (empty($rq->dateto) === false) {
            $aQuery['dateto'] = urlencode($rq->dateto);
        }

      
        if (empty($rq->rutsolicitante) === false) {
            $aQuery['rutsolicitante'] = urlencode($rq->rutsolicitante);
        }

        if (empty($rq->nombresolicitante) === false) {
            $aQuery['nombresolicitante'] = urlencode($rq->nombresolicitante);
        }
        
        $core = $this->getCoreWorkflow();

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

         $processMakerSoap = new ProcessMakerSoapWs($processMaker);
         if($processMakerSoap == false){
            return [];
         }
         //$session = $processMakerSoap->login(env("PM_USERNAME"), env("PM_PASSWORD"), false);
         $session = $core->getSessionId();

        
         if (count($aSort) == 0) {
            $aSort["field"] = "app_number";
            $aSort['sort'] = "desc";
        }

        $params = array_merge((array) $aPaginacion, (array) $aSort, (array) $aQuery);

        $participatedList = $core->getExecutedList($params);

      

        $aReturn = [];
        $aReturn['meta'] = $participatedList->meta;
        $aCases = [];
        $iCont = 0;

        foreach ($participatedList->data as $case) {
            

            $aCases[$iCont]['app_uid'] = $case->APP_UID;
            $aCases[$iCont]['del_index'] = $case->DEL_INDEX;
            $aCases[$iCont]['app_number'] = $case->APP_NUMBER;
            $aCases[$iCont]['app_tas_title'] = $case->APP_TAS_TITLE;
            $aCases[$iCont]['process_desc'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['tipodocumento_fechadocumento'] = $case->TEXT_1." ".date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['datos-solicitante'] = $case->TEXT_1.' - RUT: '.$case->TEXT_3.' - Tel: '.$case->TEXT_5.' - Email: '.$case->TEXT_4;
           // $aCases[$iCont]['materia'] = $case->TEXT_3;
           // $aCases[$iCont]['vinculada_a'] = $case->TEXT_4;
           // $aCases[$iCont]['remitente'] = $case->TEXT_8;
            //$aCases[$iCont]['destinatarios'] = $case->TEXT_5;
            $aCases[$iCont]['description'] = str_replace(array("-  -","/  /"),array("- Sin referencia -","/ Sin detalle /"),$case->TEXT_2);
            $aCases[$iCont]['fdocumento'] = date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['previous_usr_firstname'] = $case->PREVIOUS_USR_FIRSTNAME;
            $aCases[$iCont]['usrcr_usr_username'] = $case->USRCR_USR_USERNAME;
            $aCases[$iCont]['usrcr_usr_firstname'] = $case->USRCR_USR_FIRSTNAME.' '.$case->USRCR_USR_LASTNAME;
            $aCases[$iCont]['app_update_date'] = date('d/m/Y H:i', strtotime($case->APP_UPDATE_DATE));
            $aCases[$iCont]['app_create_date'] = date('d/m/Y H:i', strtotime($case->APP_CREATE_DATE));

            if (empty($case->DATETIME_1) === false && $case->DATETIME_1 != '0000-00-00 00:00:00') {
                $aCases[$iCont]['last_update'] = date('d/m/Y H:i', strtotime($case->DATETIME_1));

            } else {
                $aCases[$iCont]['last_update'] = '';
            }

            $aCases[$iCont]['task'] = $case->APPDELCR_APP_TAS_TITLE;
            $url =  "/historicosolicitud?caso=".$case->APP_UID;
            $aCases[$iCont]['urlhistorial'] = $url;//$aCases[$iCont]['urliframe'] = 'http://localhost:9001' . '/sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&sid='.$session->message.'&action=todo';
            $aCases[$iCont]['urliframe'] = env('PM_URL_FRONT'). 'sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&sid='.$session.'&action=todo';
            
            $aCases[$iCont]['action'] = '';
            $iCont++;
        }
       
        $aReturn['data'] = $aCases;

        return $aReturn;

    }

     /**
      * Tareas portomar
      */
     public function listUnassigned(Request $rq) {

        
        $aQuery = [];
        $aPaginacion = ["page" => "1", "perpage" => "10", "0" => ""];
        $aSort = [];

        if (isset($rq->process) === true) {
            $aQuery['process'] = urlencode($rq->process);
        }

        if (isset($rq->number) === true) {
            $aQuery['number'] = urlencode($rq->number);
        }

        if (isset($rq->nametask) === true) {
            $aQuery['nametask'] = urlencode($rq->nametask);
        }

        if (isset($rq->datefrom) === true) {
            $aQuery['datefrom'] = urlencode($rq->datefrom);
        }

        if (isset($rq->dateto) === true) {
            $aQuery['dateto'] = urlencode($rq->dateto);
        }

        if (isset($rq->ultimamodificacion) === true) {
            $aQuery['ultimamodificacion'] = urlencode($rq->ultimamodificacion);
        }

        if (isset($rq->rutsolicitante) === true) {
            $aQuery['rutsolicitante'] = urlencode($rq->rutsolicitante);
        }

        if (isset($rq->nombresolicitante) === true) {
            $aQuery['nombresolicitante'] = urlencode($rq->nombresolicitante);
        }

        $core = $this->getCoreWorkflow();

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

         $processMakerSoap = new ProcessMakerSoapWs($processMaker);
         if($processMakerSoap == false){
            return [];
         }
        // $session = $processMakerSoap->login(env("PM_USERNAME"), env("PM_PASSWORD"), false);
         $session = $core->getSessionId();
        //{"page":"1","perpage":"10","0":""}
        $params = array_merge((array) $aPaginacion, (array) $aSort, (array) $aQuery);

        $unassignedList = $core->getUnassignedList($params);

        $aReturn = [];
        $aReturn['meta'] = $unassignedList->meta;["page" => "1", "perpage" => "10", "0" => ""];
        $aCases = [];
        $iCont = 0;
        // var_dump($createdCases)["page" => "1", "perpage" => "10", "0" => ""];
        foreach ($unassignedList->data as $case) {

            $aCases[$iCont]['app_uid'] = $case->APP_UID;
            $aCases[$iCont]['del_index'] = $case->DEL_INDEX;
            $aCases[$iCont]['app_number'] = $case->APP_NUMBER;
            $aCases[$iCont]['app_tas_title'] = $case->APP_TAS_TITLE;
            $aCases[$iCont]['process_desc'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;

            $date1 = new Carbon($case->DEL_TASK_DUE_DATE);
            $date2 = Carbon::now();
          
            $aCases[$iCont]['expire'] = true;
            if($date1->gt($date2)){
                $aCases[$iCont]['expire'] = false;
            }

            $aCases[$iCont]['del_task_due_date'] = date('d/m/Y H:i', strtotime($case->DEL_TASK_DUE_DATE));
            $aCases[$iCont]['solicitante'] = $case->TEXT_1.' - RUT: '.$case->TEXT_3.' - Tel: '.$case->TEXT_5.' - Email: '.$case->TEXT_4;
            $aCases[$iCont]['datos-solicitante'] = $case->TEXT_1.' - RUT: '.$case->TEXT_3.' - Tel: '.$case->TEXT_5.' - Email: '.$case->TEXT_4;
           
            $aCases[$iCont]['previous_usr_firstname'] = $case->PREVIOUS_USR_FIRSTNAME.' '.$case->PREVIOUS_USR_LASTNAME;
            $aCases[$iCont]['app_create_date'] = date('d/m/Y H:i', strtotime($case->APP_CREATE_DATE));
            if (empty($case->DATETIME_1) === false && $case->DATETIME_1 != '0000-00-00 00:00:00') {
                $aCases[$iCont]['last_update'] = date('d/m/Y', strtotime($case->DATETIME_1));

            } else {
                $aCases[$iCont]['last_update'] = '';
            }

            $aCases[$iCont]['task'] = $case->APP_TAS_TITLE;
            $aCases[$iCont]['task'] = $case->APP_TAS_TITLE;
            $url =  "/historicosolicitud?caso=".$case->APP_UID;
            $aCases[$iCont]['urlhistorial'] = $url;
            $aCases[$iCont]['urliframe'] =  env('PM_URL_FRONT'). 'sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&sid='.$session.'&action=todo';
           
            $aCases[$iCont]['action'] = '';
            $iCont++;
        }
        $aReturn['data'] = $aCases;
        
        return $aReturn;
     }


     public function tomarSolicitud(Request $request){
        

        $wspm = $this->getProcessMakerWs();

       $claim = $wspm->claimCase($request->appuid);

        return response()->json($claim);
     }

    /**
     * Tareas supervision
     */
    public function listSupervisor(Request $rq) {

        
        $aQuery = [];
        $aPaginacion = ["page" => "1", "perpage" => "10", "0" => ""];
        $aSort = [];

        if (empty($rq->process) === false) {
            $aQuery['process'] = urlencode($rq->process);
        }else{
           $process =  Auth::user()->tipossolictud();
           $aProcess = [];

           foreach ( $process as $pr) {
            $aProcess[] = $pr->idsolicitud;
           }

           $aQuery['process'] = urlencode(implode(",",$aProcess));
        }

        if (empty($rq->number) === false) {
            $aQuery['number'] = urlencode($rq->number);
        }

        if (empty($rq->nametask) === false) {
            $aQuery['nametask'] = urlencode($rq->nametask);
        }

        if (empty($rq->datefrom) === false) {
            $aQuery['datefrom'] = urlencode($rq->datefrom);
        }

        if (empty($rq->dateto) === false) {
            $aQuery['dateto'] = urlencode($rq->dateto);
        }

      
        if (empty($rq->rutsolicitante) === false) {
            $aQuery['rutsolicitante'] = urlencode($rq->rutsolicitante);
        }

        if (empty($rq->nombresolicitante) === false) {
            $aQuery['nombresolicitante'] = urlencode($rq->nombresolicitante);
        }

        $core = $this->getCoreWorkflow();

        //{"page":"1","perpage":"10","0":""}
        $params = array_merge((array) $aPaginacion, (array) $aSort, (array) $aQuery);

        $allPmList2 = $core->getSupervisorList($params);

        $aReturn = [];
        $aReturn['meta'] = $allPmList2->meta;
        $aCases = [];
        $iCont = 0;

        foreach ($allPmList2->data as $case) {
            $aCases[$iCont]['app_uid'] = $case->APP_UID;
            $aCases[$iCont]['del_index'] = $case->DEL_INDEX;
            $aCases[$iCont]['app_number'] = $case->APP_NUMBER;
            $aCases[$iCont]['app_tas_title'] = $case->APP_TAS_TITLE;
            $aCases[$iCont]['process_desc'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['tipodocumento_fechadocumento'] = $case->TEXT_1." ".date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['datos-solicitante'] = $case->TEXT_1.' - RUT: '.$case->TEXT_3.' - Tel: '.$case->TEXT_5.' - Email: '.$case->TEXT_4;
           
            $aCases[$iCont]['description'] = str_replace(array("-  -","/  /"),array("- Sin referencia -","/ Sin detalle /"),$case->TEXT_2);
            $aCases[$iCont]['fdocumento'] = date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['usrcr_usr_username'] = $case->USR_USERNAME;
            $aCases[$iCont]['usrcr_usr_firstname'] = $case->USR_FIRSTNAME.' '.$case->USR_LASTNAME;
            $aCases[$iCont]['app_update_date'] = date('d/m/Y H:i', strtotime($case->APP_UPDATE_DATE));
            $aCases[$iCont]['app_create_date'] = date('d/m/Y H:i', strtotime($case->APP_CREATE_DATE));
            
            if (empty($case->DATETIME_1) === false && $case->DATETIME_1 != '0000-00-00 00:00:00') {
                $aCases[$iCont]['last_update'] = date('d/m/Y H:i', strtotime($case->DATETIME_1));

            } else {
                $aCases[$iCont]['last_update'] = '';
            }

            $aCases[$iCont]['task'] = $case->APP_TAS_TITLE;
            $url =  "/historicosolicitud?caso=".$case->APP_UID;
            $aCases[$iCont]['urlhistorial'] = $url;
            //$aCases[$iCont]['urliframe'] = $processMaker->getFullUrl() . '/sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&action=todo';
            //$aCases[$iCont]['urlmapa'] = $processMaker->getFullUrl() . '/sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/designer?prj_uid=' . $case->PRO_UID . '&prj_readonly=true&app_uid=' . $case->APP_UID;

            $aCases[$iCont]['action'] = '';
            $iCont++;
        }
        $aReturn['data'] = $aCases;

        return $aReturn;
    }



    /**
     * Historico
     */
    public function getHistoricoTarea() {
        $historicoProcesos = $this->listHistory();
        
        $historicos = array();

        foreach ($historicoProcesos->data as $historicoProceso) {
            $datos = json_decode($historicoProceso->JSON_DATA, true);

            //dd($datos);

            $files = isset($datos['adjuntos']) ? $datos['adjuntos'] : json_decode($datos['adjuntos'], true);
            $username = isset($datos['data']['username']) ? $datos['data']['username'] : $datos['username'];
            $tasktitle = $datos['tas_title'];

            $historicos[] = array(
                'datos' => $this->limpiaJsonString($datos['data']),
                'files' => $files,
                'create_date' => $datos['update_date'],
                'username' => $username,
                'task_title' => $tasktitle,
            );
        }

        return $historicos;
    }

    public function listHistory() {
        
        //$core = $this->getCoreWorkflow();
       // $historicoProcesos = $core->listHistory("39875902560b810cfb1c5a5015740262");
       // return $historicoProcesos;
       $rt = new \StdClass();
       $rt->data = [];
       return $rt;
    }

    public function limpiaJsonString($jsonObject) {
        $newJson = array();
        //arreglo clon con parametros limpios
        foreach ($jsonObject as $label => $item) {
            //omite campos inecesarios
            if ($label != 'fechaHistorial' && $label != 'username' && $label != 'case_id' && $label != 'data' && $label != 'usernamePm' && $label != 'usr' && $label != 'pass') {
                //verifica que el contenido no sea un array
                if (is_array($item)) {
                    $newJson[($label)] = ($item);
                } else {
                    $newJson[$label] = nl2br($item);

                    $newJson[($label)] = addslashes((str_replace("&gt;",">",str_replace("&lt;","<", $item))));
                }
            }
        }
        return $newJson;
    }

    public function listCaseHistorico($caso = '', $nombre = null) {

       
        $core = $this->getCoreWorkflow();

        $historicoProcesos = $core->listHistory($caso);

    }
}