<?php
namespace App\Classes\ProcessMaker;

use Illuminate\Support\Facades\Log;

class ProcessMakerWs
{
    /**
     * @type ProcessMaker
     */
    private $processMaker;

    /**
     * @type App\Classes\ProcessMaker\User
     */
    private $user;

    /**
     * @type string
     */
    private $pm_url;

    /**
     * @type string
     */
    private $pm_workspace = 'gestion_tareas';

    /**
     * ProcessMaker token data from fe user or external
     * @type array
     */
    private $token;

    /**
     * @type string
     */
    private $cliente_id;

    /**
     * @type string
     */
    private $cliente_secret;

    /**
     * @type string
     */
    private $scope;

    /**
     * ProcessMakerWs constructor.
     *
     * @param App\Classes\ProcessMaker\ProcessMaker $processMaker
     * @param App\Classes\ProcessMaker\User $user
     * @param array $token
     */
    public function __construct($processMaker = null, $user = null, $token = null)
    {
        $this->processMaker = $processMaker;
        $this->pm_url = env('PM_URL');
        $this->pm_workspace = $processMaker->getWorkspace();
        $this->cliente_id = $processMaker->getClientId();
        $this->cliente_secret = $processMaker->getClientSecret();
        $this->scope = $processMaker->getClientScope();

        if ($user !== null) {
            $this->user = $user;
           
            $this->token = $user->getTokenData();
        } else {
            $this->token = $token;
        }
    }


    /**
     * Return user not persisted data or FALSE
     * @param string $pass
     * @return App\Classes\ProcessMaker\User
     */
    public function oauthAuthorizeUser($pass = null)
    {
        if ($this->user !== null) {
            $login = $this->oauthAuthorizeAction($this->user->getUsername(), $pass);
           
            if($login == false){
               
                return false;
            }
            
            if ($login['access_token'] == '') {
                $login = $this->oauthAuthorizeAction($this->user->getUsername(), $pass);
            }
         
            if ($login['access_token'] != '') {
                $refreshDate = $this->getDateTime($this->token['expires_in']);
                $this->user->setTokenData(
                    $this->token['access_token'],
                    $this->token['refresh_token'],
                    $refreshDate
                );
                return $this->user;
            } else {
                return false;
            }
        } else {
           
            return false;
        }
    }


    /**
     * action oauthAuthorize
     * makes the call to the ProcessMaker api to authenticate the user via oauth 2.0
     *
     * @param string $username
     * @param string $pass
     * @return array|boolean
     */
    public function oauthAuthorizeAction($username, $pass = null)
    {
        if ($this->processMaker !== null) {
           
            //If the token has expired, use the refresh token to get a new one
            if (isset($this->token['expires_in']) && $this->token['expires_in'] < time() && $this->token['refresh_token'] != '') {
               
                //For the query params, we need client_id and client_secret, the scope, grant_type of refresh_token and the actual refresh token
               
                $query_params = array(
                    'grant_type' => 'refresh_token',
                    'client_id' => $this->cliente_id,
                    'client_secret' => $this->cliente_secret,
                    'scope' => $this->scoper,
                    'refresh_token' => $this->token['refresh_token'],
                );
            } elseif ((!isset($this->token) || $this->token['refresh_token'] == '') && $pass !== null) {
                 
                //This is if there is no token, then we need to get a brand new one
                //We need to send the client_id, client_secret, the scope, grant_type of password, the username and password for logging into ProcessMaker
                
                $query_params = array(
                    'grant_type' => 'password',
                    'scope' => '*',
                    'client_id' => $this->cliente_id,
                    'client_secret' => $this->cliente_secret,
                    'username' => $username,
                    'password' => $pass,
                );
            } else {
                
                //If the access token is still valid, then we don't need to make an extra api call so just return it
                $token = $this->token;
                return $token;
            }
            //Ejecuta llamada de autenticación
          
            $call = $this->callOauthService($this->getOauthEndPoint(), $query_params);

            if ($call !== false) {
                $token = $call['response'];
                $httpStatus = $call['httpStatus'];

                if ($httpStatus == 200) {
                    $this->token['access_token'] = isset($token->access_token) ? $token->access_token : $this->token['access_token'];
                    $this->token['refresh_token'] = isset($token->refresh_token) ? $token->refresh_token : $this->token['refresh_token'];
                    $this->token['expires_in'] = isset($token->expires_in) ? time() + $token->expires_in : $this->token['expires_in'];
                    //Return the token array
                    return $this->token;
                } elseif ($httpStatus == 400) {
                    if ($pass !== null) {
                        //Posible error de validación de token
                        //Se eliminan los datos y se intenta nuevamente
                        $this->token['access_token'] = '';
                        $this->token['refresh_token'] = '';
                        $this->token['expires_in'] = '';
                        //return $this->oauthAuthorizeAction($username, $pass);
                        return $this->token;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $endpoint
     * @param array $query_params
     * @return array {respose,httpStatus}
     */
    private function callOauthService($endpoint, $query_params)
    {
        $ch = curl_init($endpoint);
        //$ch = curl_init("http://host.docker.internal:9001/gestion_tareas/oauth2/token");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = json_decode(curl_exec($ch));

        error_log("Response AUTH: ".json_encode($response));

        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpStatus !== 200) {
            if ($httpStatus == 400) {
                return array(
                    'response' => $response,
                    'httpStatus' => $httpStatus,
                );
            } else {
                return $this->responseArray($response, $httpStatus);
            }
        } else {
            curl_close($ch);
            return $this->responseArray($response, $httpStatus);
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getReceivedList($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/received/' . $user);
        $endpoint .= $this->getFilter($endpointParams);

       

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

       
        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }
    
    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getExecutedList($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/executed/' . $user);
        $endpoint .= $this->getFilter($endpointParams);

     
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            error_log("Ejecutadas existo!!");
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getUnassignedList($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/unassigned/' . $user);
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getSupervisorList($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/supervisor/' . $user);
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function listHistory($appuid)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/history/' . $appuid);

      
       
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get session id
     * @return bool|\stdClass
     */
    public function getSessionId()
    {
        $endpoint = $this->getEndPoint('extrarest/session-id/');

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get star process from user
     * @return bool|\stdClass JSON object
     */
    public function getProcess()
    {
        $endpoint = $this->getEndPointLight('start-case');

      
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getMyRequests($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/myrequests/' . $user);
        $endpoint .= $this->getFilter($endpointParams);

       

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        error_log(json_encode($call));

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Start a new case and assign the logged-in user to work on the initial task in the case.
     * @param string $proUid Unique ID of process/project.
     * @param string $tasUid Unique ID of the initial task to start the case. This should be a task with a start event.
     * @param array $variables Optional. An object of case variables inside an array
     * @return \stdClass|bool
     */
    public function newCase($proUid, $tasUid, $variables = array())
    {
        $endpoint = $this->getEndPoint('cases');

        $params = array(
            'pro_uid' => $proUid,
            'tas_uid' => $tasUid,
            'variables' => $variables,
        );

       
        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Only cases in their initial task may be deleted by the currently assigned user to the case.
     * For all other cases, it is recommended to cancel them using PUT /cases/{app_uid}/cancel.
     *
     * Requiere redirección o carga de bandeja ProcessMaker ej:
     * http://{pmData.url}:{pmData.port}/sys{pmData.workspace}/{pmData.language}/{pmData.skin}/cases/casesListExtJs?action=draft&sid={session}
     *
     * @param string $appUid
     * @return bool
     */
    public function deleteCase($appUid)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid);

        /** @var array $call */
        $call = $this->pmRestRequest('DELETE', $endpoint);

        if ($call['httpStatus'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The case's status is changed to "CANCELLED"
     * The logged-in user should only be able to cancel a case if he/she is the the currently assigned user to the case
     * or the logged-in user has the PM_CANCELCASE permission in his/her role.
     *
     * @param $appUid
     * @return bool|\stdClass
     */
    public function cancelCase($appUid)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/cancel');

        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $appUid
     * @param [type] $triggerUid
     * @return void
     */
    public function executeTrigger($appUid, $triggerUid)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/execute-trigger/'.$triggerUid);

        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $appUid
     * @param [type] $triggerUid
     * @return void
     */
    public function outputDocument($appUid, $docUid)
    {
        $endpoint = $this->getEndPoint('extrarest/case/' . $appUid . '/getdocument/'.$docUid);

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * @param string $appUid
     * @param integer $delIndex Optional. Specify the delegation index of a current task which will be routed.
     * @return \stdClass|bool
     */
    public function ruteCase($appUid, $delIndex = null)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/route-case');
        $params = $delIndex > 0 ? array("del_index" => $delIndex) : null;

        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function geInputDocuments($appUid)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/input-documents');
       
       

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

       

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    

    /**
    * Get all process info
    * @return bool|\stdClass
    */
    public function geInputDocumentInformation($appUid, $docUid)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/input-documents/'.$docUid);
       
       
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

       

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * @param string $appUid
     * @param integer $delIndex Optional. Specify the delegation index of a current task which will be routed.
     * @return \stdClass|bool
     */
    public function inputDocument($appUid, $inpDocUid, $tasUid, $sComent, $path)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/input-document');
        $params = array(
            'inp_doc_uid' => $inpDocUid,
            'tas_uid' => $tasUid,
            'app_doc_comment' => $sComent,
            'form' => (phpversion() >= "5.5") ? new \CurlFile($path) : '@' . $path,
        );


        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param string $appUid
     * @param integer $delIndex Optional. Specify the delegation index of a current task which will be routed.
     * @return \stdClass|bool
     */
    public function outputAppDocument($appUid)
    {
        $endpoint = $this->getEndPoint('extrarest/document/' . $appUid . '/output-documents/1');
        


        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);


        if ($call['httpStatus'] == 200) {
            return  $call;
        } else {
            return false;
        }
    }


    /**
     * @param string $appUid
     * @param integer $delIndex Optional. Specify the delegation index of a current task which will be routed.
     * @return \stdClass|bool
     */
    public function uplodadDocument($appUid, $inpDocUid, $tasUid, $sComent, $path)
    {
        $endpoint = $this->getEndPoint('extrarest/case/' . $appUid . '/upload');
        $params = array(
            'type' => 'ATTACHED',
            'del_index' => 1,
             'field_name' => 'fileVar001',
             'field_type' => 'file',
            'file' =>curl_file_create($path),
        );


        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params, true);
        if ($call['httpStatus'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getReportGeneric($aParam)
    {
        $endpoint = $this->getEndPoint('extrarest/report/generic');
        $endpoint .= $this->getFilter($aParam);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * claim a unassigned case
     * @param string $appUid
     * @return bool
     */
    public function claimCase($appUid)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/claim');
        $params = array(
            "app_uid" => $appUid

        );

        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * claim a unassigned case
     * Utiliza servicio de ProcessMaker 2.5.x
     * @param string $appUid
     * @param string $usrUdi
     * @param integer $delIndex
     * @return bool
     */
    public function claimCaseAlternative($appUid, $usrUdi, $delIndex = null)
    {
        $pmSoapWs = new ProcessMakerSoapWs($this->processMaker);
        $pmSoapWs->login($this->user->getFeUser()->getUsername());

        if ($delIndex == null) {
            $task = $this->getCurrentTask($appUid);
            if ($task->del_index !== null) {
                $delIndex = $task->del_index;
            } else {
                error_log('claim case del_index NULL');
            }
        }

        if ($delIndex !== null) {
            return $pmSoapWs->claimCase($appUid, $delIndex, $usrUdi);
        } else {
            return false;
        }
    }

    /**
     * @param string $appUid
     * @param string $usrUidTarget user uid to be assigned to case
     * @param string $usrUidSource user uid currently assigned to case
     * @return \stdClass|bool
     */
    public function reassignCase($appUid, $usrUidTarget, $usrUidSource)
    {
        $endpoint = $this->getEndPoint('cases/' . $appUid . '/reassign-case');
        $params = array(
            "usr_uid_source" => $usrUidSource,
            "usr_uid_target" => $usrUidTarget,
        );

        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    

    /**
     * Specify the service url endpoint
     * url example: http://example.com/api/1.0/workflow/users
     * @param string $variable
     * @return string
     */
    private function getEndPoint($variable)
    {
        return "{$this->processMaker->getFullUrl()}/api/1.0/{$this->pm_workspace}/{$variable}";
    }

    /**
     * Specify the service url endpoint for ws light
     * url example: http://example.com/api/1.0/workflow/light/start-case
     * @param string $variable
     * @return string
     */
    private function getEndPointLight($variable)
    {
        return "{$this->processMaker->getFullUrl()}/api/1.0/{$this->pm_workspace}/light/{$variable}";
    }

    /**
     * Generate filters for cases endpoint
     * @param array $params
     * @return string
     */
    private function getFilter($params)
    {
        $resp = '';
        $divider = '?';
        foreach ($params as $name => $value) {
            $resp .= $divider . $name . '=' . $value;
            $divider = '&';
        }
        return $resp;
    }

    /**
    * Function to call a ProcessMaker REST endpoint and return the HTTP status code and response if any.
    * @param string $method HTTP method: "GET"(default), "POST", "PUT" or "DELETE"
    * @param string $endpoint
    * @param array $query_params Optional. Associative array containing the variables to use in the request if "POST" or "PUT" method.
    * @return boolean|array
    */

    public function pmRestRequest($method = "GET", $endpoint = "", $query_params = null, $files = false)
    {
        $ch = curl_init($endpoint);

        error_log($endpoint);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->token['access_token']));

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



        $method = strtoupper($method);



        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, ($files == true ? $query_params : http_build_query($query_params)));
        } elseif ($method == "DELETE" || $method == "PUT") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

            if ($query_params !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query_params));
            }
        }



        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



        $response = json_decode(curl_exec($ch));



        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);



        return $this->responseArray($response, $httpStatus);
    }

    /**
     *
     * HTTP status code: 200 (OK), 201 (Created), 400 (Bad Request), 404 (Not found), etc.
     * @param array $response
     * @param integer $httpStatus
     * @return array|boolean
     */
    private function responseArray($response, $httpStatus)
    {
        if ($httpStatus == 401) { //if session has expired or bad login:
            error_log("Error in HTTP status code: {$httpStatus}");
            return false;
        } elseif ($httpStatus != 200 && $httpStatus != 201) {
            error_log("Error in HTTP status code: {$httpStatus}");
            $error = json_encode($response);
            error_log("Error : {$error}");
            return false;
        } else {
            return array(
                'response' => $response,
                'httpStatus' => $httpStatus,
            );
        }
    }

    /**
     * Specify the oauth token endpoint
     * url example: http://example.com/workflow/oauth2/token
     * @return string
     */
    private function getOauthEndPoint()
    {
        return "{$this->pm_url}/{$this->pm_workspace}/oauth2/token";
    }

    /**
     * Transform timestamp to DateTime
     * @param integer $timestamp
     * @return \DateTime
     */
    private function getDateTime($timestamp)
    {
        $date = date('d-m-Y', $timestamp);
        return new \DateTime($date);
    }



    /**
     * post Claim
     * @return bool|\stdClass
     */
    public function postClaim($uid, $index, $user)
    {
        $endpoint = $this->getEndPoint('extrarest/cases/claim');
        $endpointParams = [];
        $endpointParams['app_uid'] = $uid;
        $endpointParams['del_index'] = $index;
        $endpointParams['usr_uid'] = $user;
        $endpoint .= $this->getFilter($endpointParams);
        
        $call = $this->pmRestRequest('POST', $endpoint);
        error_log(json_encode($call));
        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * post Claim
     * @return bool|\stdClass
     */
    public function postCustonConcept($endpointParams, $user)
    {
        $endpoint = $this->getEndPoint('extrarest/concepts');
        

        $endpoint .= $this->getFilter($endpointParams);
        
        $call = $this->pmRestRequest('POST', $endpoint);
        error_log(json_encode($call));
        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
    * post Claim
    * @return bool|\stdClass
    */
    public function postUpdateCustonConcept($uid, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/concepts/'.$uid);
        

        $endpoint .= $this->getFilter($endpointParams);
        
        $call = $this->pmRestRequest('POST', $endpoint);
        error_log(json_encode($call));
        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getListCustonConcept($category, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/concepts/'.$category);
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getCustonConcept($uid)
    {
        $endpoint = $this->getEndPoint('extrarest/concept/'.$uid);
        
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getValidateDownloadFile($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/document/validate/' . $user);
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getListDocument($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/document/list');
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
    * Get all process info
    * @return bool|\stdClass
    */
    public function getListDocumentFuncionario($user, $endpointParams)
    {
        $endpoint = $this->getEndPoint('extrarest/document/list/'.$user);
        $endpoint .= $this->getFilter($endpointParams);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getDocument($user, $idDocument)
    {
        $endpoint = $this->getEndPoint('extrarest/document/'.$idDocument);
       
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * Create a new user.
     * @param array $params {usr_username, usr_firstname, usr_lastname, usr_email, usr_due_date, usr_status, usr_role, usr_new_pass, usr_cnf_pass, ...}
     * @return bool|\stdClass JSON object with information about the new user
     */
    public function newUser($params)
    {
        $endpoint = $this->getEndPoint('user');
        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if (!isset($call['response'])) {
            error_log("Error accessing");
            return false;
        } elseif (isset($call['response']->error)) {
            error_log("Error info: Code: {$call['response']->error->code} Message: {$call['response']->error->message}");
            return false;
        } else {
            return $call['response'];
        }
    }

    /**
     * Create a simply new user.
     *
     * @param string $username
     * @param string $email
     * @param string $name
     * @param string $pass
     * @param string $lastname opcional
     * @param string $phone
     * @param string $role PROCESSMAKER_ADMIN, PROCESSMAKER_OPERATOR
     * @return bool|\stdClass
     */
    public function newUserDefault($username, $email, $name, $pass, $lastname = '-', $phone = '-', $role = 'PROCESSMAKER_ADMIN')
    {
        $params = array(
            'usr_username' => $username,
            'usr_firstname' => $name,
            'usr_lastname' => $lastname,
            'usr_email' => $email,
            'usr_due_date' => date('Y-m-d', strtotime('+100 years')),
            'usr_status' => 'ACTIVE',
            'usr_role' => $role,
            'usr_new_pass' => $pass,
            'usr_cnf_pass' => $pass,
            'usr_phone' => $phone,
        );
        return $this->newUser($params);
    }

    /**
     * Update the information about a specified user.
     * @param string $usrUid
     * @param array $params {usr_username, usr_firstname, usr_lastname, usr_email, usr_due_date, usr_status, usr_role, usr_new_pass, usr_cnf_pass, ...}
     * @return bool|\stdClass JSON object with information about the user
     */
    public function updateUser($usrUid, $params)
    {
        $endpoint = $this->getEndPoint('user/' . $usrUid);
        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint, $params);

        if (is_null($call) == false) {
            if ($call['httpStatus'] == 200) {
                return true;
            } else {
                error_log('Error info: ' . json_encode($call));
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get information about a specified user.
     * @param string $usrUid
     * @return bool|\stdClass JSON object with information about the user
     */
    public function getUser($usrUid)
    {
        $endpoint = $this->getEndPoint('user/' . $usrUid);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Returns a list of all users in the workspace, including users with "INACTIVE" and "VACATION" status.
     * @return bool|\stdClass JSON object with information about the user
     */
    public function getUsers()
    {
        $endpoint = $this->getEndPoint('extrarest/users');
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Update user data
     * @param string $usrUid
     * @param array $params {usr_username, usr_firstname, usr_lastname, usr_email, usr_due_date, usr_status, usr_role, usr_new_pass, usr_cnf_pass, ...}
     * @return bool|\stdClass JSON object with information about the user
     */
    public function setUser($usrUid, $params)
    {
        $endpoint = $this->getEndPoint('user/' . $usrUid);
        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint, $params);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Return total cases data from user
     *
     * @param $usrUid
     * @return array
     */
    public function getUserCaseInfo($usrUid)
    {
        $response = array(
            'TOTAL' => 0,
            'TO_DO' => 0,
            'DRAFT' => 0,
            //'PAUSED'=>0,
            //'CANCELLED'=>0,
            'COMPLETED' => 0,
        );

        foreach ($response as $key => $data) {

            // add endpoint params
            $endpointParams = $this->setParamsArray(0, 0, null, null, null, null, null, $key != 'TOTAL' ? $key : null);
            $param = 'cases/advanced-search/paged' . $this->getFilter($endpointParams) . '&usr_uid=' . $usrUid;
            $endpoint = $this->getEndPoint($param);

            /** @var array $call */
            $call = $this->pmRestRequest('GET', $endpoint);

            if ($call['httpStatus'] == 200) {
                $data = $call['response'];
                $response[$key] = $data->total;
            }

            if ($key == 'TOTAL' && $data->total = 0) {
                // termina siclo si el usurio no tiene tareas
                break;
            }
        }

        return $response;
    }

    /**
     * @param string $title Nombre del grupo
     * @param bool $active group status ACTIVE
     * @return bool|mixed
     */
    public function newGroup($title, $active = true)
    {
        $endpoint = $this->getEndPoint('group');

        $params = array(
            'grp_title' => $title,
            'grp_status' => $active == true ? 'ACTIVE' : 'INACTIVE',
        );

        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if ($call['httpStatus'] == 200 || $call['httpStatus'] == 201) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * @param string $grpUid Group unique ID
     * @param string $title Nombre del grupo
     * @param bool $active group status ACTIVE
     * @return bool|mixed
     */
    public function updateGroup($grpUid, $title, $active = true)
    {
        $endpoint = $this->getEndPoint('group/' . $grpUid);

        $params = array(
            'grp_title' => $title,
            'grp_status' => $active == true ? 'ACTIVE' : 'INACTIVE',
        );

        /** @var array $call */
        $call = $this->pmRestRequest('PUT', $endpoint, $params);

        if ($call['httpStatus'] == 200 || $call['httpStatus'] == 201) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * @param $grpUid
     * @return bool
     */
    public function deleteGroup($grpUid)
    {
        $endpoint = $this->getEndPoint('group/' . $grpUid);
        /** @var array $call */
        $call = $this->pmRestRequest('DELETE', $endpoint);

        if ($call['httpStatus'] == 200 || $call['httpStatus'] == 201) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all ACTIVE groups from user
     *
     * @param string $usrUid
     * @param string $filter case insensitive string to search for in the group name
     * @return array
     */
    public function getGroupsFromUser($usrUid, $filter = null)
    {
        /** @var array $grupos todos los grupos*/
        $grupos = $this->getGroups($filter);
        $gruposActivos = array();

        foreach ($grupos as $grupo) {
            if ($grupo->grp_status == 'ACTIVE' && $grupo->grp_tasks > 0) {
                $usuariosGrupo = $this->getGroupUsers($grupo->grp_uid);
                foreach ($usuariosGrupo as $usuario) {
                    if ($usuario->usr_uid == $usrUid) {
                        $gruposActivos[] = $grupo;
                    }
                }
            }
        }
        return $gruposActivos;
    }

    /**
     * Get a list of all the groups in the workspace (including groups with "INACTIVE" status).
     *
     * @param string $filter Case insensitive string to search for in the group name
     * @return bool|\stdClass groups are returned in alphabetical order
     */
    public function getGroups($filter = null)
    {
        $endpoint = $filter == null ? $this->getEndPoint('groups') : $this->getEndPoint('groups?filter=' . $filter);

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get information about a specified group (including groups with "INACTIVE" status).
     * @param string $grpUid group uid
     * @return bool|\stdClass groups are returned in alphabetical order
     */
    public function getGroup($grpUid)
    {
        $endpoint = $this->getEndPoint('groups/' . $grpUid);
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get list the assigned users to a specified group
     * @param string $grpUid group uid
     * @return bool|\stdClass
     */
    public function getGroupUsers($grpUid)
    {
        $endpoint = $this->getEndPoint('groups/' . $grpUid . '/users');
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Assign a user to a specified group.
     * @param string $grpUid group uid
     * @param string $usrUid
     * @return bool|\stdClass
     */
    public function setGroupUser($grpUid, $usrUid)
    {
        $endpoint = $this->getEndPoint('group/' . $grpUid . '/user');
        $params = array(
            "usr_uid" => $usrUid,
        );
        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);
       
        if ($call['httpStatus'] == 201) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Unassign (remove) a user from a group so no longer a member of the group.
     * @param string $grpUid group uid
     * @param string $usrUid user uid
     * @return bool
     */
    public function unassignGroupUser($grpUid, $usrUid)
    {
        $endpoint = $this->getEndPoint('group/' . $grpUid . '/user/' . $usrUid);

        $call = $this->pmRestRequest('DELETE', $endpoint);
         if ($call['httpStatus'] == 200 || $call['httpStatus'] == 201) {
             return true;
         } else {
             return false;
         }
    }

    /**
     * Get a list of the roles in the workspace.
     * @return bool|\stdClass
     */
    public function getRoles()
    {
        $endpoint = $this->getEndPoint('roles');
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get a list of projects
     * @return bool|\stdClass
     */
    public function getProjects()
    {
        $endpoint = $this->getEndPoint('project');
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get the definition of a project activity
     * @param string $prjUid Project UID
     * @return bool|\stdClass
     */
    public function getProject($prjUid)
    {
        $endpoint = $this->getEndPoint("project/$prjUid");
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Assign a user or group to an activity
     * @param string $prjUid Project UID
     * @param string $actUid Activity UID
     * @param string $aasUid User or group UID
     * @param string $aasType User type. default 'user'
     * @return bool
     */
    public function setAssignmenUser($prjUid, $actUid, $aasUid, $aasType = 'user')
    {
        $endpoint = $this->getEndPoint("project/$prjUid/activity/$actUid/assignee");
        $params = array(
            'aas_uid' => $aasUid,
            'aas_type' => $aasType,
        );

        /** @var array $call */
        $call = $this->pmRestRequest('POST', $endpoint, $params);

        if ($call['httpStatus'] == 201) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Get all process info
     * @return bool|\stdClass
     */
    public function getAllProcess()
    {
        $endpoint = $this->getEndPoint('extrarest/process');

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }


    /**
     * Get all task info
     * @return bool|\stdClass
     */
    public function getAllTaks()
    {
        $endpoint = $this->getEndPoint('extrarest/task');

        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }

    /**
     * Get the definition of a project activity
     * @param string $prjUid Project UID
     * @return bool|\stdClass
     */
    public function getTaksProcess($prjUid)
    {
        $endpoint = $this->getEndPoint("extrarest/taskprocess/$prjUid");
        /** @var array $call */
        $call = $this->pmRestRequest('GET', $endpoint);

        if ($call['httpStatus'] == 200) {
            return $call['response'];
        } else {
            return false;
        }
    }
}
