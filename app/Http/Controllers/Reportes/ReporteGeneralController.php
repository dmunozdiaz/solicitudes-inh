<?php

namespace App\Http\Controllers\Reportes;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\PmGroups;
use App\Traits\UtilsTrait;
use App\Models\PmgrupoUser;
use Illuminate\Support\Str;
use App\Mail\ChangePassword;
use Illuminate\Http\Request;


use App\Models\ReporteGeneral;
use App\Models\TipSolicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Exports\ReportegeneralExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ReporteGenericoRequest;
use App\Services\Validator\UsuarioValidatorServices;

class ReporteGeneralController extends Controller
{
    use UtilsTrait;
    
   
    public function view(TipSolicitudes $tipSolicitudes, ReporteGeneral $repor)
    {
        $core = $this->getCoreWorkflow();
        $allPmProcess = $core->listAllProcess();


        $url = \Route::current();

        
      // dd($repor->getReporte(1, 'Dirección de Operaciones', 'Departamento de Caminos Rurales y Bacheo de Calles', null, 2022, null));
        
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

        $conf = $configBandejasPaginas['supervision'];

        if ($conf['por_tomar'] == true) {
            $portomaractivo = "active show";
        }else if ($conf['por_hacer'] == true) {
            $porhaceractivo = "active show";
        }   else if ($conf['ejecutadas'] == true) {
            $ejecutadasactivo = "active show";
        } else if ($conf['supervisor'] == true) {
            $supervisoractivo = "active show";
        }

        return view('reportes.reportegenerico.view')->with([
            'areas' => $tipSolicitudes->getAreas(),
            'direcciones' => $tipSolicitudes->getDirecciones(),
            "porhaceractivo" => true,
            "portomaractivo" => true,
            "ejecutadasactivo" => true,
            "supervisoractivo" => true,
            "porhacer" => $conf['por_hacer'],
            "portomar" => $conf['por_tomar'],
            "ejecutadas" => $conf['ejecutadas'],
            "supervisor" => $conf['supervisor'],
            "allPmTipoTramite" => [],
            "allPmProcedencia" => [],
            "allPmComunas" => [],
            "allPmUsers" => [],
            "allPmProcess" => $allPmProcess,
        ]);
    }

    public function listado(Request $rq) {

        
        $reportes = ReporteGeneral::select('id','direccion','area','descsolicitud','anio','descestado','estadoreporte')->where('user_id','=',Auth::user()->id)->limit(5)->orderBy('id', 'desc')->get();

        $aReturn['data'] = $reportes;
        $aReturn['recordsTotal'] = $reportes->count();

        //dd($aReturn);
        
        return $aReturn;
    }

    
    public function generarReporte(ReporteGenericoRequest $request)
    {

        $rq = collect($request);
       
        DB::beginTransaction();
        try {

            $reporte = new ReporteGeneral();

            $reporte->user_id = Auth::user()->id;
            $reporte->direccion = $rq->get('direccion');
            $reporte->area = $rq->get('area');
            $reporte->solicitud = $rq->get('proceso');
            $reporte->descsolicitud = $rq->get('proceso') == null ? null : $rq->get('descproceso') ;
            $reporte->anio = $rq->get('anio');
            $reporte->estado = $rq->get('estado');
            $reporte->descestado = $rq->get('estado') == null ? null : $rq->get('descestado');
            $reporte->estadoreporte = 1;
            $reporte->ruta_archivo = 'reportes/generico/reporte_'.date('Ymdhis').'.xlsx';

            $reporte->save();

            DB::commit();

            $reportes = ReporteGeneral::limit(5)->orderBy('id', 'desc')->get('id')->toArray();
            
            ReporteGeneral::whereNotIn('id',$reportes)->delete();

            (new ReportegeneralExport($reporte))->queue($reporte->ruta_archivo)->chain([
                new NotifyUserOfCompletedExport(Auth::user(), $reporte->id),
            ]);
           
            
            return response()->json([
                'success' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    
        
}
