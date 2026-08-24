<?php
namespace App\Classes\ProcessMaker;

class User
{

    /**
     * Create date
     *
     * @var \DateTime
     */
    protected $crdate = NULL;
    
    /**
     * Update date
     *
     * @var \DateTime
     */
    protected $tstamp = NULL;
    
    /**
     * pmUsrUid
     *
     * @var string
     */
    protected $pmUsrUid = '';
    
    /**
     * ProcessMaker access_token
     *
     * @var string
     */
    protected $pmAccessToken = '';
    
    /**
     * ProcessMaker refresh_token
     *
     * @var string
     */
    protected $pmRefreshToken = '';
    
    /**
     * ProcessMaker expires_in
     *
     * @var \DateTime
     */
    protected $pmExpiresIn = NULL;
    
    /**
     * Typo3 acccess Token
     *
     * @var string
     */
    protected $typo3AccessToken = '';
    
    /**
     * pmEmailNotification
     *
     * @var bool
     */
    protected $pmEmailNotification = FALSE;
    
    /**
     * Username
     *
     * @var string
     */
    protected $username = "";
        
    /**
     * Returns the pmAccessToken
     *
     * @return string $pmAccessToken
     */
    public function getPmAccessToken()
    {
        return $this->pmAccessToken;
    }
    
    /**
     * Sets the pmAccessToken
     *
     * @param string $pmAccessToken
     * @return void
     */
    public function setPmAccessToken($pmAccessToken)
    {
        $this->pmAccessToken = $pmAccessToken;
    }
    
    /**
     * Returns the pmRefreshToken
     *
     * @return string $pmRefreshToken
     */
    public function getPmRefreshToken()
    {
        return $this->pmRefreshToken;
    }
    
    /**
     * Sets the pmRefreshToken
     *
     * @param string $pmRefreshToken
     * @return void
     */
    public function setPmRefreshToken($pmRefreshToken)
    {
        $this->pmRefreshToken = $pmRefreshToken;
    }
    
    /**
     * Returns the pmExpiresIn
     *
     * @return \DateTime $pmExpiresIn
     */
    public function getPmExpiresIn()
    {
        return $this->pmExpiresIn;
    }
    
    /**
     * Sets the pmExpiresIn
     *
     * @param \DateTime $pmExpiresIn
     * @return void
     */
    public function setPmExpiresIn(\DateTime $pmExpiresIn = NULL)
    {
        $this->pmExpiresIn = $pmExpiresIn;
    }
    
    /**
     * Returns the feUser
     *
     * @return string $feUser
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Sets the feUser
     *
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * Sets all token info
     *
     * @param string $pmAccessToken
     * @param string $pmRefreshToken
     * @param \DateTime $pmExpiresIn
     * @return void
     */
    public function setTokenData($pmAccessToken, $pmRefreshToken, $pmExpiresIn)
    {
        $this->pmAccessToken = $pmAccessToken;
        $this->pmRefreshToken = $pmRefreshToken;
        $this->pmExpiresIn = $pmExpiresIn;
    }

    /**
     * Reset all ProcessMaker token info
     * 
     * @return void
     */
    public function resetTokenData()
    {
        $this->pmAccessToken = '';
        $this->pmRefreshToken = '';
        $this->pmExpiresIn = NULL;
    }
    
    /**
     * Return the Token data as ProcessMaker format
     *
     * @return array
     */
    public function getTokenData()
    {
        return array(
            'access_token' => $this->pmAccessToken,
            'refresh_token' => $this->pmRefreshToken,
            'expires_in' => $this->pmExpiresIn != NULL ? $this->pmExpiresIn->getTimestamp() : 0
        );
    }
    
    /**
     * Returns the pmUsrUid
     *
     * @return string $pmUsrUid
     */
    public function getPmUsrUid()
    {
        return $this->pmUsrUid;
    }
    
    /**
     * Sets the pmUsrUid
     *
     * @param string $pmUsrUid
     * @return void
     */
    public function setPmUsrUid($pmUsrUid)
    {
        $this->pmUsrUid = $pmUsrUid;
    }
    
    /**
     * Returns the mobile
     *
     * @return \CEISUFRO\CeisPmTypo3User\Domain\Model\Mobile $mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }
    
    /**
     * Sets the mobile
     *
     * @param \CEISUFRO\CeisPmTypo3User\Domain\Model\Mobile $mobile
     * @return void
     */
    public function setMobile(\CEISUFRO\CeisPmTypo3User\Domain\Model\Mobile $mobile)
    {
        $this->mobile = $mobile;
    }
    
    /**
     * Returns create date
     *
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }
    
    /**
     * Returns update date
     *
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }
    
    /**
     * Returns the typo3AccessToken
     *
     * @return string typo3AccessToken
     */
    public function getTypo3AccessToken()
    {
        return $this->typo3AccessToken;
    }
    
    /**
     * Sets the typo3AccessToken
     * generate token from uid and create date
     *
     * @return void
     */
    public function setTypo3AccessToken()
    {
        if($this->getCrdate() == NULL) {
            $date = new \DateTime('now');
            $token = $this->getUid() . $date->getTimestamp();
        }else{
            $token = $this->getUid() . $this->getCrdate()->getTimestamp();
        }
        $token = str_pad($token, 16, '0', STR_PAD_LEFT);
        $this->typo3AccessToken = $token;
    }
    
    /**
     * Returns the pmEmailNotification
     *
     * @return bool $pmEmailNotification
     */
    public function getPmEmailNotification()
    {
        return $this->pmEmailNotification;
    }
    
    /**
     * Sets the pmEmailNotification
     *
     * @param bool $pmEmailNotification
     * @return void
     */
    public function setPmEmailNotification($pmEmailNotification)
    {
        $this->pmEmailNotification = $pmEmailNotification;
    }
    
    /**
     * Returns the boolean state of pmEmailNotification
     *
     * @return bool
     */
    public function isPmEmailNotification()
    {
        return $this->pmEmailNotification;
    }
    

}