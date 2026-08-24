<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View as view;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;

use Respect\Validation\Validator as v;
use App\Classes\ProcessMaker\CoreWorkflow;
use App\Classes\ProcessMaker\ProcessMaker;
use App\Classes\ProcessMaker\User as Userpm;
use App\Classes\ProcessMaker\ProcessMakerWs; 
use App\Classes\ProcessMaker\ProcessMakerSoapWs;

trait UtilsTrait {

    /**
     *
     * @param string $msg   mensaje que se quiere mostrar
     * @param string $icon  icono que se mostrara en el mensaje: flaticon-warning, etc..
     * @param string $type  tipo de mensaje a mostrar: primary, success, warning, dark, info y danger
     * @param string $title titulo de la pagina
     * @param string $description   descripción de la pagina
     * @return Illuminate\View\View
     */
    public function getViewError($msg, $icon, $type, $title, $description): \Illuminate\View\View {
        return view('errors.validation',
                [
                    'msg' => $msg,
                    'icon' => $icon,
                    'type' => $type,
                    'page_title' => $title,
                    'page_description' => $description,
                ]
        );
    }

    /**
     * @param string $action accion a ejecutar encrypt o decrypt
     * @param string $string cadena a encriptar o desencriptar
     * @return string
     */
    public function encrypt_decrypt($action, $string): string {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = env('SECRET_KEY');
        $secret_iv = env('SECRET_IV');
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    /**
     * Funcion que guarda los logs en .csv
     * @param type $usuario 
     * @param type $accion
     * @param type $ip
     * @param type $finisolicitud
     * @param type $ffinsolicitud
     * @param type $resultado
     */
    public static function generaLog($realizador, $ip, $accion, $usuario, $fecha) {

        $files = array_diff(scandir(storage_path() . '/logs/csv/', SCANDIR_SORT_DESCENDING), array('..', '.'));

        if (isset($files[0])) {
            $file = $files[0];
        } else {
            $file = date('Y-m') . "_log" . ".csv";
        }

        $_aFile = explode('.', $file);
        $_bFile = explode('_',$_aFile[0]);
        $date1 = $_bFile[0];
        $date2 = date('Y-m');

        $to = Carbon::createFromFormat('Y-m', $date2);
        $from = Carbon::createFromFormat('Y-m', $date1);
        $diff_in_months = $to->diffInMonths($from);

        $meses = config('app.log_meses');

        if ($diff_in_months > $meses) {
            $filename = date('Y-m') . "_log" . ".csv";
        } else {
            $filename = $file;
        }

        $delimiter = ";";
        $isfile = is_file(storage_path() . '/logs/csv/' . $filename);
        $f = fopen(storage_path() . '/logs/csv/' . $filename, 'a');
        if ($isfile == false) {

            $fields = array('Realizador', 'Ip', 'Accion', 'Usuario', 'Fecha y Hora de la Acción');
            fputcsv($f, $fields, $delimiter);
        }

        fputcsv($f, array($realizador, $ip, $accion, $usuario, $fecha), $delimiter);
        fclose($f);
    }
    
    /**
     * Genera un token para el envío de email
     * @return type
     */
    public function generateToken() {
        // This is set in the .env file
        $key = config('app.key');

        // Illuminate\Support\Str;
        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
        return hash_hmac('sha256', Str::random(40), $key);
    }


    public function getProcessMakerWs(){
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        
        $user = new Userpm();
        
        $user->setUsername(Auth::user()->email);
        $user->setPmUsrUid(Auth::user()->uidpm);
        
        $dataPm = $this->encrypt_decrypt('decrypt', Auth::user()->tokenpm);
        $oDataPm = json_decode($dataPm);
        $pmWs = new CoreWorkflow($user, $processMaker, $oDataPm->pass);
       
        $wspm = new ProcessMakerWs($processMaker, $user, $pmWs->token);
        return $wspm;
    }

    public function getProcessMakerWsUserParam($userParam){
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        
        $user = new Userpm();
        
        $user->setUsername($userParam->email);
        $user->setPmUsrUid($userParam->uidpm);
        
        $dataPm = $this->encrypt_decrypt('decrypt', $userParam->tokenpm);
        $oDataPm = json_decode($dataPm);
        $pmWs = new CoreWorkflow($user, $processMaker, $oDataPm->pass);
       
        $wspm = new ProcessMakerWs($processMaker, $user, $pmWs->token);
        return $wspm;
    }

    public function getProcessMakerWsPublic(){
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        
        $user = new Userpm();
        
        $user->setUsername(env('PM_USERNAME_PUBLIC'));
        $user->setPmUsrUid(env('PM_USR_UID_PUBLIC'));
        
       
        $pmWs = new CoreWorkflow($user, $processMaker, env('PM_PASSWORD_PUBLIC'));
       
        $wspm = new ProcessMakerWs($processMaker, $user, $pmWs->token);
        return $wspm;
    }

 

    public function getCoreWorkflow(){
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        
        $user = new Userpm();
        
        $user->setUsername(Auth::user()->email);
        $user->setPmUsrUid(Auth::user()->uidpm);
        
        $dataPm = $this->encrypt_decrypt('decrypt', Auth::user()->tokenpm);
        $oDataPm = json_decode($dataPm);
        
        $core = new CoreWorkflow($user, $processMaker, $oDataPm->pass);
       
        
        return $core;
    }

    public function getCoreWorkflowPublic(){
        $processMaker = new ProcessMaker();
        $processMaker->setWorkspace(env('PM_WORKSPACE'));
        $processMaker->setClientId(env('PM_CLIENTE_ID'));
        $processMaker->setClientSecret(env('PM_CLIENT_SECRET'));
        $processMaker->setSkin(env('PM_SKIN'));
        $processMaker->setLanguage(env('PM_LANGUAGE'));
        $processMaker->setClientScope('');
        $processMaker->setFullUrl(env('PM_URL'));

        
        $user = new Userpm();
        
        $user->setUsername(env('PM_USERNAME_PUBLIC'));
        $user->setPmUsrUid(env('PM_USR_UID_PUBLIC'));
        
       
        $core = new CoreWorkflow($user, $processMaker, env('PM_PASSWORD_PUBLIC'));
       
        
        return $core;
    }

}
