<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller{
    
    public function list() {

        return view('tareas.reportes.list')->with([
            "allPmTipoTramite" => [],
            "allAnios" => [],
            "allPmProcedencia" => [],
            "allPmUsers" => [],
            "allPmTask" => []
        ]);

    }
    
    public function generateExcelGenericoAction() {

        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');

        $user = new User();
        $user->setUsername(env("PM_USERNAME"));
        $user->setPmUsrUid(ENV('PM_USR_UID'));
    
        $core = new CoreWorkflow($user, $processMaker, env("PM_PASSWORD"));

        $allPmProcess = $pmWs->getReportGeneric($aParam);

        

    }

}