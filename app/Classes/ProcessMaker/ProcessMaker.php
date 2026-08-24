<?php
namespace App\Classes\ProcessMaker;

class ProcessMaker {
    /**
     * PM URL host
     *
     * @var string
     * @validate NotEmpty
     */
    protected $url = '';
    
    /**
     * PM URL extra path
     *
     * @var string
     */
    protected $urlPath = '';
    
    /**
     * PM puerto
     *
     * @var int
     */
    protected $port = 0;
    
    /**
     * Secure Sockets Layer
     *
     * @var bool
     */
    protected $sslOn = false;
    
    /**
     * PM workspace
     *
     * @var string
     * @validate NotEmpty
     */
    protected $workspace = '';
    
    /**
     * PM client ID from oauth
     *
     * @var string
     * @validate NotEmpty
     */
    protected $clientId = '';
    
    /**
     * PM client secret from oauth app
     *
     * @var string
     * @validate NotEmpty
     */
    protected $clientSecret = '';
    
    /**
     * PM client scope from oauth app
     *
     * @var string
     */
    protected $clientScope = '';
    
    /**
     * active
     *
     * @var bool
     */
    protected $active = FALSE;
    
    /**
     * PM default skin
     *
     * @var string
     */
    protected $skin = '';
    
    /**
     * PM default language
     *
     * @var string
     */
    protected $language = '';
    
    /**
     * PM DataBase User
     *
     * @var string
     */
    protected $dbUser = '';
    
    /**
     * PM DataBase Password
     *
     * @var string
     */
    protected $dbPassword = '';
    
    /**
     * FE user persistence storage Pid
     *
     * @var int
     */
    protected $feUserStorage = 0;
    
    /**
     * PM DataBase Host
     *
     * @var string
     */
    protected $dbHost = 'localhost';
    
    /**
     * PM DataBase Port
     *
     * @var int
     */
    protected $dbPort = 3306;
    
    /**
     * PM DataBase Name
     *
     * @var string
     */
    protected $dbName = '';

    /**
     * PM Url API 
     *
     * @var string
     */
    protected $apiUrl = '';

    /**
     * PM Username api
     *
     * @var string
     */
    protected $apiUsername = '';

    /**
     * PM password api
     *
     * @var string
     */
    protected $apiPassword = '';


    /**
     * PM Url API  Rpti
     *
     * @var string
     */
    protected $apiUrlRpti = '';

    /**
     * PM Username api Rpti
     *
     * @var string
     */
    protected $apiUsernameRpti = '';

    /**
     * PM password api Rpti
     *
     * @var string
     */
    protected $apiPasswordRpti = '';

    /**
     * Returns the apiurl
     *
     * @return string $workspace
     */
    public function getapiUrl()
    {
        return $this->apiUrl;
    }
    
    /**
     * Sets the apiurl
     *
     * @param string $apiurl
     * @return void
     */
    public function setapiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

     /**
     * Returns the apiurlrpti
     *
     * @return string $apiurlrpti
     */
    public function getapiUrlRpti()
    {
        return $this->apiUrlRpti;
    }
    
    /**
     * Sets the apiurl
     *
     * @param string $apiurlrpti
     * @return void
     */
    public function setapiUrlRpti($apiUrlRpti)
    {
        $this->apiUrlRpti = $apiUrlRpti;
    }

    
    /**
     * Returns the apiUsername
     *
     * @return string $apiUsername
     */
    public function getapiUsername()
    {
        return $this->apiUsername;
    }
    
    /**
     * Sets the apiUsername
     *
     * @param string $apiUsername
     * @return void
     */
    public function setapiUsername($apiUsername)
    {
        $this->apiUsername = $apiUsername;
    }


    /**
     * Returns the apiUsernameRpti
     *
     * @return string $apiUsernameRpti
     */
    public function getapiUsernameRpti()
    {
        return $this->apiUsernameRpti;
    }
    
    /**
     * Sets the apiUsernameRpti
     *
     * @param string $apiUsernameRpti
     * @return void
     */
    public function setapiUsernameRpti($apiUsernameRpti)
    {
        $this->apiUsernameRpti = $apiUsernameRpti;
    }

    /**
     * Returns the apiPassword
     *
     * @return string $apiPassword
     */
    public function getapiPassword()
    {
        return $this->apiPassword;
    }
    
    /**
     * Sets the apiPassword
     *
     * @param string $apiPassword
     * @return void
     */
    public function setapiPassword($apiPassword)
    {
        $this->apiPassword = $apiPassword;
    }

    /**
     * Returns the apiPasswordRpti
     *
     * @return string $apiPasswordRpti
     */
    public function getapiPasswordRpti()
    {
        return $this->apiPasswordRpti;
    }
    
    /**
     * Sets the apiPassword
     *
     * @param string $apiPasswordRpti
     * @return void
     */
    public function setapiPasswordRpti($apiPasswordRpti)
    {
        $this->apiPasswordRpti = $apiPasswordRpti;
    }
    
    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return parse_url('//' . $this->url, PHP_URL_HOST);
    }
    
    /**
     * @return string
     */
    public function getFullUrl()
    {
        /**return empty($this->port) ?
            "{$this->getScheme()}://{$this->getHost()}{$this->urlPath}" :
            "{$this->getScheme()}://{$this->getHost()}:{$this->port}{$this->urlPath}";**/
            //return "https://fea-conadi-pm.dev.lazos.cl";
            //return "http://host.docker.internal:9001";
            return $this->url;
    }
    
    /**
     * Returns host
     *
     * @return string
     */
    public function getHost()
    {
        return parse_url('//' . $this->url, PHP_URL_HOST);
    }
    
    /**
     * Returns path from url
     *
     * @return string
     */
    public function getPath()
    {
        return parse_url('//' . $this->url, PHP_URL_PATH);
    }
    
    /**
     * Sets the url
     *
     * @param string $url subdomain.domain.com
     * @return void
     */
    public function setFullUrl($url)
    {
        //$url = rtrim($url, '/');
        //$search = array('http://', 'https://');
        //$url = str_ireplace($search, '', trim($url));
        $this->url = $url;
    }
    
    /**
     * Returns ProcessMaker scheme: http or https
     *
     * @return string
     */
    public function getScheme()
    {
        if ($this->sslOn == TRUE) {
            return 'https';
        } else {
            //Si TYPO3 tiene SSL, ProcessMaker tambien debe tener SSL
            return \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SSL') ? 'https' : 'http';
        }
    }
    
    /**
     * Returns the workspace
     *
     * @return string $workspace
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }
    
    /**
     * Sets the workspace
     *
     * @param string $workspace
     * @return void
     */
    public function setWorkspace($workspace)
    {
        $this->workspace = $workspace;
    }
    
    /**
     * Returns the port
     *
     * @return int $port
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     * Sets the port
     *
     * @param int $port
     * @return void
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
    
    /**
     * Returns the clientId
     *
     * @return string $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    
    /**
     * Sets the clientId
     *
     * @param string $clientId
     * @return void
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }
    
    /**
     * Returns the clientSecret
     *
     * @return string $clientSecret
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    
    /**
     * Sets the clientSecret
     *
     * @param string $clientSecret
     * @return void
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }
    
    /**
     * Returns the clientScope
     *
     * @return string $clientScope
     */
    public function getClientScope()
    {
        return $this->clientScope;
    }
    
    /**
     * Sets the clientScope
     *
     * @param string $clientScope
     * @return void
     */
    public function setClientScope($clientScope)
    {
        $this->clientScope = $clientScope;
    }
    
    /**
     * Returns the active
     *
     * @return bool $active
     */
    public function getActive()
    {
        return $this->active;
    }
    
    /**
     * Sets the active
     *
     * @param bool $active
     * @return void
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    
    /**
     * Returns the boolean state of active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
    
    /**
     * Returns the skin
     *
     * @return string $skin
     */
    public function getSkin()
    {
        return $this->skin;
    }
    
    /**
     * Sets the skin
     *
     * @param string $skin
     * @return void
     */
    public function setSkin($skin = 'neoclassic')
    {
        $this->skin = trim($skin);
    }
    
    /**
     * Returns the language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * Sets the language
     *
     * @param string $language en, es
     * @return void
     */
    public function setLanguage($language = 'en')
    {
        $this->language = $language;
    }
    
    /**
     * Returns the dbUser
     *
     * @return string $dbUser
     */
    public function getDbUser()
    {
        return $this->dbUser;
    }
    
    /**
     * Sets the dbUser
     *
     * @param string $dbUser
     * @return void
     */
    public function setDbUser($dbUser)
    {
        $this->dbUser = trim($dbUser);
    }
    
    /**
     * Returns the dbPassword
     *
     * @return string $dbPassword
     */
    public function getDbPassword()
    {
        return $this->dbPassword;
    }
    
    /**
     * Sets the dbPassword
     *
     * @param string $dbPassword
     * @return void
     */
    public function setDbPassword($dbPassword)
    {
        $this->dbPassword = $dbPassword;
    }
    
    /**
     * Returns the urlPath
     *
     * @return string $urlPath
     */
    public function getUrlPath()
    {
        return $this->urlPath;
    }
    
    /**
     * Sets the urlPath
     *
     * @param string $urlPath
     * @return void
     */
    public function setUrlPath($urlPath = '')
    {
        $this->urlPath = trim($urlPath);
        if (!empty($this->urlPath)) {
            $this->urlPath = rtrim($this->urlPath, '/');
            if ($this->urlPath[0] != '/') {
                $this->urlPath = "/{$this->urlPath}";
            }
        }
    }
    
    /**
     * Returns the sslOn
     *
     * @return bool $sslOn
     */
    public function getSslOn()
    {
        return $this->sslOn;
    }
    
    /**
     * Sets the sslOn
     *
     * @param bool $sslOn
     * @return void
     */
    public function setSslOn($sslOn)
    {
        $this->sslOn = $sslOn;
    }
    
    /**
     * Returns the boolean state of sslOn
     *
     * @return bool
     */
    public function isSslOn()
    {
        return $this->sslOn;
    }
    
    /**
     * Sets the feUserStorage
     *
     * @param int $feUserStorage
     * @return void
     */
    public function setFeUserStorage($feUserStorage)
    {
        $this->feUserStorage = $feUserStorage;
    }
    
    /**
     * Returns the dbHost
     *
     * @return string $dbHost
     */
    public function getDbHost()
    {
        return $this->dbHost;
    }
    
    /**
     * Sets the dbHost
     *
     * @param string $dbHost
     * @return void
     */
    public function setDbHost($dbHost)
    {
        $this->dbHost = trim($dbHost);
    }
    
    /**
     * Returns the dbPort
     *
     * @return int $dbPort
     */
    public function getDbPort()
    {
        return $this->dbPort;
    }
    
    /**
     * Sets the dbPort
     *
     * @param int $dbPort
     * @return void
     */
    public function setDbPort($dbPort)
    {
        if(empty($dbPort)) {
            $this->dbPort = 3306;
        }else{
            $this->dbPort = $dbPort;
        }
    }
    
    /**
     * Returns the dbName
     *
     * @return string $dbName
     */
    public function getDbName()
    {
        return $this->dbName;
    }
    
    /**
     * Sets the dbName
     *
     * @param string $dbName
     * @return void
     */
    public function setDbName($dbName)
    {
        $this->dbName = trim($dbName);
    }
}