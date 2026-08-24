<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Models\TipSolicitudes;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudesCiudadanas;

class DashboardController extends Controller
{
    use UtilsTrait;


    public function viewDashboard()
    {

        return view('dashboard', [
          'aniosession' => $request->session()->get('anio-session')
        ]);
    }


    public function dashboard()
    {

        return view(
            'dashboard.dashboard-supervisor',
            [
            'tiposolicitudes' =>  Auth::user()->tipossolictudDireccion(Auth::user()->direccionUser()[0]->id),
            'direcciones' => Auth::user()->direccionUser(),
            'anios' => SolicitudesCiudadanas::anioSolicitudes()
        ]
        );
    }

    public function cargarTipoSolicitudes(Request $rq)
    {
        $solicitudes =  Auth::user()->tipossolictudDireccion($rq->direccion);
        return response()->json($solicitudes);
    }

    public function indicadores(Request $rq)
    {
        $meses = [
          1 => 0,
          2 => 0,
          3 => 0,
          4 => 0,
          5 => 0,
          6 => 0,
          7 => 0,
          8 => 0,
          9 => 0,
          10 => 0,
          11 => 0,
          12 => 0,
        ] ;

        $graficoCantSolicitudes = [
          'ingresada' => SolicitudesCiudadanas::graficoCantidadSolicitudes(1, $rq->direccion, $rq->tipsolicitud, $rq->periodo1)[0],
          'terminada' => SolicitudesCiudadanas::graficoCantidadSolicitudes(2, $rq->direccion, $rq->tipsolicitud, $rq->periodo1)[0],
          'enproceso' => SolicitudesCiudadanas::graficoCantidadSolicitudes(3, $rq->direccion, $rq->tipsolicitud, $rq->periodo1)[0],
        ];

        $graficoSolPorMesIngresados = SolicitudesCiudadanas::graficoSolPorMes($rq->anio, '1,2,3', $rq->direccion, $rq->tipsolicitud);
        $aGraficoSolPorMesIngresados = $meses;

        foreach ($graficoSolPorMesIngresados  as $mes) {

            $aGraficoSolPorMesIngresados[(int)$mes->meses] = $mes->solicitudes;
        }

        $graficoSolPorMesIngresadosTerm = SolicitudesCiudadanas::graficoSolPorMesTerminadas($rq->anio, $rq->direccion, $rq->tipsolicitud);
        $aGraficoSolPorMesIngresadosTerm = $meses;

        foreach ($graficoSolPorMesIngresadosTerm  as $mes) {

            $aGraficoSolPorMesIngresadosTerm[(int)$mes->meses] = $mes->solicitudes;
        }


        $demandas = SolicitudesCiudadanas::graficoDemandaSoli($rq->direccion, $rq->periodo2);



        return response()->json([
          'tiempoPromedio' => SolicitudesCiudadanas::tiempoPromedio($rq->direccion, $rq->tipsolicitud)[0],
          'tiempoMaximoRespuesta' => SolicitudesCiudadanas::tiempoMaximoRespuesta($rq->direccion, $rq->tipsolicitud)[0],
          'tiempoPromedioEnProceso' => SolicitudesCiudadanas::tiempoPromedioEnProceso($rq->direccion, $rq->tipsolicitud)[0],
          'tiempoMaximoEnProceso' => SolicitudesCiudadanas::tiempoMaximoEnProceso($rq->direccion, $rq->tipsolicitud)[0],
          'tiempoPromedioTotalRespuesta' => SolicitudesCiudadanas::tiempoPromedioTotalRespuesta($rq->direccion, $rq->tipsolicitud)[0],
          'tiempoMaximoTotalRespuesta' => SolicitudesCiudadanas::tiempoMaximoTotalRespuesta($rq->direccion, $rq->tipsolicitud)[0],
          'semaforo' => $this->listSupervisor($rq->direccion, $rq->tipsolicitud),
           'graficocantsolicitudes' => $graficoCantSolicitudes,
           'graficosolpormesingresados' => $aGraficoSolPorMesIngresados,
           'graficosolpormesingresadoster' => $aGraficoSolPorMesIngresadosTerm,
           'graficodemandas' => $demandas
        ]);
    }


    private function listSupervisor($direccion = null, $tipossolictud = null)
    {


        $aQuery = [];
        $aPaginacion = ["page" => "1", "perpage" => "10", "0" => ""];
        $aSort = [];
        if(empty($tipossolictud) === true && empty($direccion) === false){
          $process  = TipSolicitudes::where('id_direccion' , '=', $direccion)->get();
          $aProcess = [];

          foreach ($process as $pr) {
              $aProcess[] = $pr->idsolicitud;
          }

          $aQuery['process'] = urlencode(implode(",", $aProcess));
        }else if (empty($tipossolictud) === false) {
            $process  = TipSolicitudes::find($tipossolictud);
            $aQuery['process'] = urlencode( $process->idsolicitud);
        } else {
            $process =  Auth::user()->tipossolictud();
            $aProcess = [];

            foreach ($process as $pr) {
                $aProcess[] = $pr->idsolicitud;
            }

            $aQuery['process'] = urlencode(implode(",", $aProcess));
        }
        $core = $this->getCoreWorkflow();

        //{"page":"1","perpage":"10","0":""}
        $params = array_merge((array) $aPaginacion, (array) $aSort, (array) $aQuery);

        $allPmList2 = $core->getSupervisorList($params);

        $aReturn = [];

        $aCases = [];
        $iCont = 0;

        $iIngresadas = 0;
        $iExpiraIngresada = 0;
        $iProceso = 0;
        $iExpiraProceso = 0;
        $iTerminado= 0;
        foreach ($allPmList2->data as $case) {
            if($case->DEL_INDEX == 2) {
                $iIngresadas++;
            } else {

                if($case->APP_STATUS == 'TO_DO') {
                    $iProceso++;
                } elseif($case->APP_STATUS_LABEL == 'COMPLETED') {
                    $iTerminado++;
                }

            }



            $date1 = new Carbon($case->DEL_TASK_DUE_DATE);
            $date2 = Carbon::now();

            if($date1->gt($date2) == false) {
                if($case->DEL_INDEX == 2) {
                    $iExpiraIngresada++;
                } else if($case->APP_STATUS_LABEL != 'COMPLETED') {
                    $iExpiraProceso++;
                }
            }


            $iCont++;

        }
        $aReturn['iIngresadas'] = $iIngresadas;
        $aReturn['iExpiraIngresada'] = $iExpiraIngresada;
        $aReturn['iProceso'] = $iProceso;
        $aReturn['iExpiraProceso'] = $iExpiraProceso;
        $aReturn['iTerminado'] = $iTerminado;
        $aReturn['iTotal'] = $iCont;

        return $aReturn;
    }


}
