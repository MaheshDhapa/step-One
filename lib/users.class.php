    <?php
 
 
/**
 * StepIn Solutions venture
 * @package stepOne
 */
class users extends siCommon {

    public $oSession;
    

    public function __construct() {
        global $oSession;
        $this->oSession = & $oSession;
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }
 // Do Login
        public function doLogin($sUserCredential) 
        {
            $this->oSession->setSession(getconfig('sSessionName'),$sUserCredential);
        }
        // Is Logedin
        public function isLoggedin() 
        {
            return $this->oSession->getSession(getconfig('sSessionName'));
        }
        // Do LogOut
        public function doLogOut() 
        {
            $this->oSession->removeSession();
        }
        
        /**
         * function for varification of registered user
         * @param type $sVerificationKey
         * @return boolean
         */
        public function getLoginSessionAfterVerification($sVerificationKey) 
        {
            if(empty($sVerificationKey)) return false;
            $sAndWhere = ' 1 = 1';
            $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
            $sAndWhere .= " AND u.verification_key ='".$sVerificationKey."'";
            
            $sSql = "SELECT 
                            u.id_user,
                            u.first_name,
                            u.email,
                            u.verification_key,
                            u.mobile_number
                    FROM
                            users u
                    WHERE".$sAndWhere;
           
            $sQueryHendler = $this->oObject->getList($sSql,array(),array(),array(),array(),array());
            return $this->oObject->getData($sQueryHendler,"ARRAY");             
        }
        
  }
  
