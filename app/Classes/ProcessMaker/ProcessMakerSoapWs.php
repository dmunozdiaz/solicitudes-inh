<?php

namespace App\Classes\ProcessMaker;

use App\Classes\ProcessMaker\ProcessMaker;

class ProcessMakerSoapWs
{

    /**
     * variable que contiene la instalacion del cliente SOAP
     */
    private $client;

    /**
     * @type ProcessMaker
     */
    private $processMaker;

    /**
     * ProcessMaker user session
     * @type String
     */
    private $sessionId;

    public $bActivo = true;

    /**
     * @param ProcessMaker $pm
     */
    public function __construct(ProcessMaker $pm)
    {
        if($pm->getFullUrl() == ''){
            $this->bActivo = false;
            return false;
        }

        $urlWsProcessMaker = "{$pm->getFullUrl()}/sys{$pm->getWorkspace()}/{$pm->getLanguage()}/green/services/wsdl2";

       
        
        try {
            $arrContextOptions=stream_context_create(array(
                "ssl" => array(
                     "verify_peer" => false,
                     "verify_peer_name" => false,
                )));

            $this->client = new \SoapClient($urlWsProcessMaker, array('cache_wsdl' => 0, "stream_context" => $arrContextOptions));
            
        } catch (SoapFault $e) { // Do NOT try and catch "Exception" here
            error_log(json_encode($e));
        }
        $this->processMaker = $pm;
    }

    /**
     * @param string $username
     * @param string $pass md5 ProcessMaker user password
     * @return void
     */
    public function login($username = null, $pass = null, $md5 = true )
    {

            
        if (!empty($pass)) {

            error_log("Password real: ".$pass);
            
            if($md5 === true){
                $pass = 'md5:' . $pass;
            }

            error_log("user: ".$username);
            error_log("password: ".$pass);
            
            $params = array(array('userid' => $username, 'password' => $pass));
            
            $result = $this->client->__soapCall('login', $params);
            if ($result->status_code == 0) {
                $this->sessionId = $result->message;
                //$GLOBALS["TSFE"]->fe_user->setKey("ses", "tx_pm_core_sessionid", $this->sessionId);
                //$GLOBALS["TSFE"]->fe_user->sesData_change = true;
                //$GLOBALS["TSFE"]->fe_user->storeSessionData();
                error_Log("conectado");
            } else {
                error_log("No se a podido conectar a ProcessMaker.\nError Numero: $result->status_code " .
                    "Error Message: $result->message");
            }

        } else {
            error_log("ProcessMaker user password not found");
        }

        return $result;

    }

    /**
     * Return ProcessMaker user session id
     * @return String
     */
    public function getSessionId()
    {
        if ($this->sessionId == null || $this->sessionId == '') {
            $this->login();
            return $this->sessionId;
        } else {
            return $this->sessionId;
        }
    }

    /**
     * Remove user session data
     * @return void
     */
    public function clearSessionId()
    {
        if ($GLOBALS['TSFE']->fe_user) {
            $GLOBALS['TSFE']->fe_user->removeSessionData();
        }

    }

    /**
     * Claim a case
     * WSDL tomar caso
     *
     * @param string $caseId app_uid
     * @param integer $delindex
     * @param string $aUser
     *
     * @return bool
     */
    public function claimCase($caseId, $delindex, $aUser)
    {
        $aParam = array('caseId' => $caseId, 'delIndex' => $delindex, 'userUid' => $aUser);
        $params = array(array('sessionId' => $this->sessionId, 'nameMethod' => 'reclamarTarea', 'paramMethod' => $aParam));
        $retorno = $this->client->__soapCall('externalService', $params);
        if ($retorno->status_code == 0) {
            return true;
        } else {
            error_log('error claim case ' . json_encode($retorno));
            return false;
        }
    }

}