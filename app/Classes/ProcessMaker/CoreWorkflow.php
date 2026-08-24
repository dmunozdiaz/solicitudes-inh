<?php
namespace App\Classes\ProcessMaker;
use App\Classes\ProcessMaker\ProcessMakerWs;
use App\Classes\ProcessMaker\User;
use App\Classes\ProcessMaker\ProcessMaker;

class CoreWorkflow
{

    /**
     * @type ProcessMakerWs
     */
    private $processMakerWs;

    /**
     * @type ProcessMaker
     */
    private $processMaker;

    /**
     * @type User
     */
    private $user;


        /**
     * CoreWorkflow constructor.
     *
     * @param User $user
     * @param ProcessMaker $pm
     * @param string $pass
     */
    public function __construct(User $user = null, ProcessMaker $pm = null, $pass = null)
    {
        if ($pm == null) {
            error_log('Configuracion Processmaker no encontrada');
        } else {

            if ($user !== null) {
                
                $this->user = $user;
                $this->processMakerWs = new ProcessMakerWs($pm, $this->user);
                //$this->user = $pass !== null ? $this->processMakerWs->oauthAuthorizeUser($pass) : $this->processMakerWs->oauthAuthorizeUser();
                $this->processMakerWs->oauthAuthorizeUser($pass);

                if ($user !== false) {
                    $this->token = $this->user->getTokenData();
                    error_log("Token data: ".json_encode($this->token));
                }
            } else {
                error_log('usuario no encontrado');
            }
        }

    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * Returns ProcessMaker configuration
     * @return \App\Classes\ProcessMaker\ProcessMakerWs
     */
    public function getProcessMaker()
    {
        return $this->processMakerWs == null ? null : $this->processMakerWs->getProcessMaker();
    }

    /**
     * @return bool|\stdClass
     */

    public function getReceivedList($aParam = null)
    {
        return $proceses = $this->processMakerWs->getReceivedList($this->user->getPmUsrUid(), $aParam);
    }

    /**
     * @return bool|\stdClass
     */
    public function getExecutedList($aParam)
    {
        return $proceses = $this->processMakerWs->getExecutedList($this->user->getPmUsrUid(), $aParam);
    }

    /**
     * @return bool|\stdClass
     */
    public function getUnassignedList($aParam)
    {   
        return $proceses = $this->processMakerWs->getUnassignedList($this->user->getPmUsrUid(),$aParam);  
    }

    /**
     * @return bool|\stdClass
     */
    public function getSupervisorList($aParam)
    {
        return $proceses = $this->processMakerWs->getSupervisorList($this->user->getPmUsrUid(),$aParam);
    }

    /**
     * @return bool|\stdClass
     */
    public function listHistory($appuid)
    {
        return $proceses = $this->processMakerWs->listHistory($appuid);
    }

    /**
     * @return bool|\stdClass
     */

    public function getReportGeneric($aParam)
    {
        return $proceses = $this->processMakerWs->getReportGeneric($aParam);
    }

    public function getSessionId()
    {
        return $session = $this->processMakerWs->getSessionId();
    }

        /**
     * @return bool|array
     */
    public function listAssignedProcess()
    {
        $proceses = $this->processMakerWs->getProcess();

        if ($proceses !== false) {
            $response = array();
            foreach ($proceses as $process) {

                // {0:'nombre proceso',1:'nombre primera tarea)'}
                $processName = explode('(', html_entity_decode($process->text));

                $response[$process->processId] = array(
                    'name' => $processName[0],
                    'taskUid' => $process->taskId,
                    'taskName' => str_replace(')', '', $processName[1]),
                );
            }
            return $response;
        } else {
            return false;
        }
    }

    /**
     * Create new draft case
     *
     * @param string $proUid
     * @param string $tasUid
     * @param array $vars
     * @return \stdClass|bool
     */
    public function createCase($proUid, $tasUid, $vars = null)
    {
        $resp = $this->processMakerWs->newCase($proUid, $tasUid, $vars);
        if ($resp->app_uid !== null) {
            return $resp;
        } else {
            return false;
        }
    }



    /**
     * @return bool|\stdClass
     */

    public function getMyRequests($aParam)
    {
        return $proceses = $this->processMakerWs->getMyRequests($this->user->getPmUsrUid(),$aParam);
    }

    /**
     * @return bool|\stdClass
     */
    public function listAllProcess()
    {
        return $proceses = $this->processMakerWs->getAllProcess();
    }


     /**
     * @return bool|\stdClass
     */
    public function listAllTaks()
    {
        return $proceses = $this->processMakerWs->getAllTaks();
    }
 
     /**
     * @return bool|\stdClass
     */
    public function getTaksProcess($prjUid)
    {
        return $proceses = $this->processMakerWs->getTaksProcess($prjUid);
    }
 

}