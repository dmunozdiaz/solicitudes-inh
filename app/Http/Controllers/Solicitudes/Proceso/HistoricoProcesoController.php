<?php

namespace App\Http\Controllers\Solicitudes\Proceso;

use DB;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Classes\ProcessMaker\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs; 

class HistoricoProcesoController extends Controller{

    use UtilsTrait;
    
    public function listCaseHistorico(Request $request) {

        $caso = $request->input('caso');

       
        $core = $this->getCoreWorkflow();

        $historicoProcesos = $core->listHistory($caso);

        //dd($historicoProcesos);

        $historicos = array();

        error_log("Historicos: ".count($historicoProcesos->data));

        //dd($historicoProcesos);

        foreach ($historicoProcesos->data as $historicoProceso) {
            //dd($historicoProceso);


            $datos = json_decode($historicoProceso->JSON_DATA, true);
            error_log("datos");
            //dd($datos);
           //$files = isset($datos['adjuntos']) ? $datos['adjuntos'] : json_decode($datos['adjuntos'], true);
          $files = [];
            error_log("files");
            $username = isset($datos['data']['username']) ? $datos['data']['username'] : $datos['username'];
            error_log("username");
            $tasktitle = $datos['tas_title'];

            $historicos[] = array(
                'datos' => $this->limpiaJsonString($datos['data']),
                'files' => $files,
                'create_date' => $datos['update_date'],
                'username' => $username,
                'task_title' => $tasktitle,
            );
        }

        return view('solicitudes.historico.listCaseHistorico')->with([
            "historicos" => $historicos,
        ]);

    }
    

    public function limpiaJsonString($jsonObject)
    {
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