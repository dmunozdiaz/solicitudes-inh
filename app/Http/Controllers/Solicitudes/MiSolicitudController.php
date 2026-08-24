<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;

use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs; 
use App\Classes\ProcessMaker\ProcessMakerSoapWs;
use App\Classes\ProcessMaker\User;

class MiSolicitudController extends Controller{
    
    public function list() {

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        $user = new User();
        $user->setUsername(env("PM_USERNAME"));
        $user->setPmUsrUid(env('PM_USR_UID'));
    
        $core = new CoreWorkflow($user, $processMaker, env("PM_PASSWORD"));

        //{"page":"1","perpage":"10","0":""}
        $params = array("page" => "1", "perpage" => "10");

        $allPmProcess = $core->listAssignedProcess();

        //dd($allPmProcess);

        $participatedList = $core->getExecutedList($params);

        //dd($participatedList);


        //dd( $this->tabs() );
        return view('tareas.missolicitudes.list')->with([
            "tabs" => $this->tabs(),
            "allPmProcedencia" => [],
            "allPmComunas" => [],
            "allPmUsers" => [],
            "allPmTask" => [],
            //"historicos" => $this->getHistoricoTarea()
        ]);
    }

    public function tabs() {
        $tabs = [];
        $tabs[] = array(
            "tab-id" => env("PM_PRO_UID"),
            "title" => "Solicitud Gestion de Documentos",
            "url" => "nc/mis-solicitudes/?tx_lzpmmissolicitudes_lzpmmissolicitudes%5Bproceso%5D=3642124805e96289e964ad2039927368&tx_lzpmmissolicitudes_lzpmmissolicitudes%5BnombreProceso%5D=Tr%C3%A1mite%20RPTI%20&tx_lzpmmissolicitudes_lzpmmissolicitudes%5BtareaInicioId%5D=7100020205e96289f7f3b64021918976&tx_lzpmmissolicitudes_lzpmmissolicitudes%5Baction%5D=listCreatedCases&tx_lzpmmissolicitudes_lzpmmissolicitudes%5Bcontroller%5D=MiSolicitud&cHash=284d3349dca6201ad24224b487bdceb0",
            "newCaseUri" =>  "/tareas/nuevatarea?proUid=".env("PM_PRO_UID")."&tasUid=".env("PM_TASK_UID"),
            "contentSection" => ".tx-lz-pm-missolicitudes",
            "active" => true,
            "feuserGroup" => null
        );
     
        return $tabs;
    }

    public function listSolicitudes(Request $request) {
        $process = $request->get('process');
        
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        $user = new User();
        $user->setUsername(env("PM_USERNAME"));
        $user->setPmUsrUid(ENV('PM_USR_UID'));
    
        $core = new CoreWorkflow($user, $processMaker, env("PM_PASSWORD"));

        //$processMakerSoap = new ProcessMakerSoapWs($processMaker);
        //$session = $processMakerSoap->login(env("PM_USERNAME"), env("PM_PASSWORD"), false);
        $session = $core->getSessionId();

        $params = array("page" => 1, "perpage" => 10, "process" => $process);

        $solicitudes = $core->getMyRequests($params);

        //dd($solicitudes);

        $aReturn = [];
        $aReturn['meta'] = $solicitudes->meta;
        $aCases = [];
        $iCont = 0;

        $aCases = [];
        $iCont = 0;
        foreach ($solicitudes->data as $case) {
           
            $aCases[$iCont]['app_number'] = $case->APP_NUMBER;
            $aCases[$iCont]['tipo_documento'] = $case->TEXT_1;
            $aCases[$iCont]['fdocumento'] = date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['tipodocumento_fechadocumento'] = $case->TEXT_1." ".date('d/m/Y', strtotime($case->DATETIME_1));
            $aCases[$iCont]['materia'] = $case->TEXT_3;
            $aCases[$iCont]['vinculada_a'] = $case->TEXT_4;
            $aCases[$iCont]['destinatarios'] = $case->TEXT_5;
            $aCases[$iCont]['solicitante'] = $case->TEXT_1;
            $aCases[$iCont]['description'] = str_replace(array("-  -","/  /"),array("- Sin referencia -","/ Sin detalle /"),$case->TEXT_2);
            $aCases[$iCont]['app_tas_title'] = $case->APPDELCR_APP_TAS_TITLE;
            $aCases[$iCont]['process_desc'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['app_pro_title'] = $case->APP_PRO_TITLE;
            $aCases[$iCont]['usrcr_usr_firstname'] = $case->USRCR_USR_FIRSTNAME.' '.$case->USRCR_USR_LASTNAME;
            $aCases[$iCont]['app_update_date'] = date('d/m/Y', strtotime($case->APP_UPDATE_DATE)); //d/m/Y H:i
            $url = "/tareas/historicosolicitud?caso=".$case->APP_UID;
            $aCases[$iCont]['urlhistorial'] = $url;
            $aCases[$iCont]['urliframe'] = $processMaker->getFullUrl() . '/sys' . $processMaker->getWorkspace() . '/' . $processMaker->getLanguage() . '/' . $processMaker->getSkin() . '/cases/open?APP_UID=' . $case->APP_UID . '&DEL_INDEX=' . $case->DEL_INDEX . '&sid='.$session.'&action=todo'; 
            $aCases[$iCont]['action'] = '';
            $iCont++;
        }

        $aReturn['data'] = (array) $aCases;


        return $aReturn;
    }

    public function new(Request $request) {
        $proUid = $request->get('proUid');
        $tasUid = $request->get('tasUid');

        error_log("Nueva tarea!!");

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        $user = new User();
        $user->setUsername(env("PM_USERNAME"));
        $user->setPmUsrUid(env('PM_USR_UID'));
    
        $core = new CoreWorkflow($user, $processMaker, env("PM_PASSWORD"));

        //$processMakerSoap = new ProcessMakerSoapWs($processMaker);
        //$session = $processMakerSoap->login(env("PM_USERNAME"), env("PM_PASSWORD"), false);

        $session = $core->getSessionId();

        $case = $core->createCase($proUid, $tasUid);

        return view('tareas.missolicitudes.new')->with([
            //session" => $session->message,
            "session" => $session,
            "case" => $case->app_uid,
            "pmData" => $processMaker,
            "fullUrl" => $processMaker->getFullUrl(), //$processMaker->getFullUrl()
            "workspace" => $processMaker->getWorkspace(),
            "language" => $processMaker->getLanguage(),
            "skin" => $processMaker->getSkin()
        ]);
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

}