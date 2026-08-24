<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Upload;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Models\ReporteGeneral;

use App\Models\ReporteEspecial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

class DownloadFileController extends Controller
{
    use UtilsTrait;
    
    public function downloadFile(Request $request)
    {
        $wspm = $this->getProcessMakerWs();
   
        $doc = $wspm->outputDocument($request->appuid, $request->docuid);
       
        $path       = public_path($doc->namefile);
        $contents   = base64_decode($doc->file);

        //store file temporarily
        file_put_contents($path, $contents);

        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }


    public function downloadReporte(Request $request)
    {
        $reporte = ReporteGeneral::where('id','=',$request->idreporte)->first();
        $path = storage_path('app/').$reporte->ruta_archivo;
        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }


    public function downloadReporteEspecial(Request $request)
    {
        $reporte = ReporteEspecial::where('id','=',$request->idreporte)->first();
        $path = storage_path('app/').$reporte->ruta_archivo;
        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
