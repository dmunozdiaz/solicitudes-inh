<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Upload;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

class DownloadFilePublicController extends Controller
{
    use UtilsTrait;
    
    public function downloadFile(Request $request)
    {
        $wspm = $this->getProcessMakerWsPublic();
   
        $doc = $wspm->outputDocument($request->appuid, $request->docuid);
      
        //$path       = public_path($doc->namefile);
        $path       = storage_path('app/').$doc->namefile;
        $contents   = base64_decode($doc->file);

        //store file temporarily
        file_put_contents($path, $contents);

        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
