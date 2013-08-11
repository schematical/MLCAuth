<?php
/**
 * @package mlc
 * @subpackage auth
 */
class MLCAuthDriver{
    
    const SESSION_COOKIE = "SESSION_KEY";
    const PRE_SALT = "GHI789O";
    const POST_SALT = "EB299I8";
    const SESSION_LENGHT = 999;//In Hours
    const LETTERS = '!@#$^&*()abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    const DEFAULT_LENGTH = 10;
    const DELIMITER = '||';
    
    protected static $objUser = null;
	protected static $objAccount = null;
    protected static $strPath = '/';
    protected static $strDomain = null;
    public static function SetCookiePath($strPath){
    	self::$strPath = $strPath;
    }
  	public static function SetCookieDomain($strDomain){
    	self::$strDomain = $strDomain;
    }
    
    /**
     *
     * Creates a new user 
     *
     * @param <String> $strEmail
     * @param <String> $strPassword
     * @param <Integer> $intIdAccount
     * @return <User>
     */
    public static function CreateUser($strEmail, $strPassword, $intIdAccount = null){
    	$objUser = AuthUser::LoadSingleByField('email', $strEmail);
		if(!is_null($objUser)){
			throw new MLCAuthException("User account already exists");
		}
		
        $objNUser = new AuthUser();
        $objNUser->Email = strtolower($strEmail);
        $objNUser->Password = self::HashPass($strPassword);
               
        $objNUser->Save();
		if(is_null($intIdAccount)){
			$objAccount = new AuthAccount();
			$objAccount->IdUser = $objNUser->IdUser;
			$objAccount->CreDate = MLCDateTime::Now();
			$objAccount->Save();			
			$objNUser->IdAccount = $objAccount->IdAccount;
			self::$objAccount = $objAccount;
		}else{
			$objNUser->IdAccount = $intIdAccount;
			self::$objAccount = AuthAccount::LoadById($intIdAccount);
		}
		$objNUser->Save();
		self::$objUser = $objNUser;
		
        return $objNUser;
    }

	public static function CreateTempUserSession(){
        $objNUser = new AuthUser();  
        $objNUser->Save();
		$objNUser->creDate = MLCDateTime::Now();
		self::$objUser = $objNUser;
        self::StartSession($objNUser);
        return $objNUser;
		
    }
    /**
     *Hashes the password using which ever salting/hashing we determin
     *
     * @param <String> $strPassword
     * @return <String>
     */
    public static function HashPass($strPassword){
        return md5($strPassword);
    }
    
    /**
     *
     * Takes an email and password and returns true if the user exists and the session was created
     *
     * @param <String> $strEmail
     * @param <String> $strPassword
     * @return <Boolean>
     */
	public static function Authenticate($strEmail, $strPassword){
		$objUser = AuthUser::LoadSingleByField('email', strtolower($strEmail));
		//die($strEmail . "," . self::HashPass($strPassword));
		if(is_null($objUser)){
			return false;
		}
		
		if($objUser->password == self::HashPass($strPassword)){
        	self::$objUser = $objUser;
		}
        if(!is_null(self::$objUser)){
            self::StartSession(self::$objUser);
            return true;
        }else{
            return false;
        }        
		
	}

    public static function AuthenticateByUserSetting($strKey, $strValue, $strPassword){
        $objUser = AuthUser::QueryByUserSetting($strKey, $strValue);
        //die($strEmail . "," . self::HashPass($strPassword));
        if(is_null($objUser)){
            return false;
        }

        if($objUser->password == self::HashPass($strPassword)){
            self::$objUser = $objUser;
        }
        if(!is_null(self::$objUser)){
            self::StartSession(self::$objUser);
            return true;
        }else{
            return false;
        }

    }
    /**
     * This function checks the cookies to see if there is an active session for this user
     * and returns the session if there is
     * @return <Session>
     */
    public static function LoadSession($strSessionKey = null){
        if(is_null($strSessionKey)){
            $strSessionKey = MLCCookieDriver::GetCookie(self::SESSION_COOKIE);
        }
		
        if(!is_null($strSessionKey)){
            $objSession = AuthSession::LoadSingleByField('sessionKey', $strSessionKey);
			
            return $objSession;
        }else{
            return null;
        }
    }
    public static function User($blnForceReload = false){
    	if(is_null(self::$objUser) || $blnForceReload){
	        $objSession = self::LoadSession();
			
	        if(!is_null($objSession)){
	            self::$objUser = AuthUser::LoadById($objSession->IdUser);
	        }
    	}
    	return self::$objUser;
    }
	public static function Account(){
		if(!is_null(self::$objAccount)){
			return self::$objAccount;
		}
		$objUser = self::User();
		
		if(is_null($objUser)){
			return null;
		}
		$objAccount = null;
	
		
		if(is_null($objAccount)){
			$objAccount = AuthAccount::LoadById($objUser->IdAccount);
		}
		
		return $objAccount;
	}
	public static function IdAccount(){
		$objAccount = self::Account();
		if(!is_null($objAccount)){
			return $objAccount->IdAccount;
		}
		return null;
	}

    public static function IdUserTypeCd(){
        $objUser = self::User();
        if(!is_null($objUser)){
            return $objUser->idUserTypeCd;
        }else{
            return null;
        }
    }
    public static function IdUser(){
        $objUser = self::User();
        if(!is_null($objUser)){
            return $objUser->idUser;
        }else{
            return null;
        }
    }
    public static function StartSession($objUser){
        //load any other sessions for that user and kill them
        $arrSessions = AuthSession::Query(
        	sprintf(
        		'WHERE startDate < "%s" AND endDate > "%s" AND idUser = %s',
        		MLCDateTime::Now(),
        		MLCDateTime::Now(),
        		$objUser->idUser
        	)
		);
        if(count($arrSessions) > 0){
           
            foreach($arrSessions as $objTSession){
                $objTSession->endDate = MLCDateTime::Now();
                $objTSession->Save();
            }
        }

        //
        $objSession = new AuthSession();
        $strName = self::SESSION_COOKIE;
        //here were going to salt the current time with a string
        $strSalt = sprintf("%s%s%s", self::PRE_SALT, time(), self::POST_SALT);
        $strValue = md5($strSalt);
        $objSession->sessionKey = $strValue;
        $objSession->startDate = MLCDateTime::Now();
       	$dttEndDate = new DateTime(MLCDateTime::Now());
		$dttEndDate->add(new DateInterval('PT'. self::SESSION_LENGHT . 'H'));
        $objSession->EndDate = date_format($dttEndDate,"Y-m-d H:i:s");
        $objSession->IpAddress = $_SERVER['REMOTE_ADDR'];
        $objSession->IdUser = $objUser->idUser;
        $objSession->Save();

        $intExpire = time() + (3600 * self::SESSION_LENGHT);
        MLCCookieDriver::SetCookie($strName, $strValue, $intExpire, self::$strPath, self::$strDomain);
    }
    public static function EndSession($objSession = null){
    	if(is_null($objSession)){
        	$objSession = self::LoadSession();
    	}
        MLCCookieDriver::RemoveCookie(self::SESSION_COOKIE, self::$strPath, self::$strDomain);
        if(!is_null($objSession)){
            $objSession->EndDate = MLCDateTime::Now();
            $objSession->Save();
        }
    }
    public static function GetActiveSession($mixUser, $blnForceEnd = false){
    	if(is_numeric($mixUser)){
    		$objUser = AuthUser::LoadById($mixUser);
    	}elseif(get_class($mixUser) == 'AuthUser'){
    		$objUser = $mixUser;
    	}else{
    		throw new Exception("First parameter must be either an Integer or a User object");
    	}
    	$arrSessions = AuthSession::Query(
            //die(
            sprintf(
                "WHERE idUser = %s AND startDate <= '%s' AND endDate > '%s'",
                $objUser->idUser,
                MLCDateTime::Now(),
                MLCDateTime::Now()
            )
        );

    	if($blnForceEnd){
    		foreach($arrSessions as $objSession){
    			self::EndSession($objSession);
    		}
    	}
    	return $arrSessions;
    }
    public static function GenRandomString($intLength = null){
        if(is_null($intLength)){
            $intLength = self::DEFAULT_LENGTH;
        }
        $strPass = '';
        for($i = 0; $i < $intLength; $i++){
            $strPass .= substr(self::LETTERS, round(rand(0, strlen(self::LETTERS))), 1);
        }
        return $strPass;
    }
    public static function SetCookie($strName, $strValue, $intExpire = null, $strPath = null, $strDomain = null, $blnSecure = null, $blnHttponly = null){
    	setcookie($strName, $strValue, $intExpire, $strPath, $strDomain, $blnSecure, $blnHttponly);
    	return true;
    }
    public static function GetCookie($strCookieName){
    	if(array_key_exists($strCookieName, $_COOKIE)){
    		return $_COOKIE[$strCookieName];
    	}else{
    		return null;
    	}
    }
    public static function RemoveCookie($strCookieName,  $strPath = null, $strDomain = null){
    	if(array_key_exists($strCookieName, $_COOKIE)){
    		setcookie($strCookieName, '', time()-3600,  $strPath, $strDomain);
    		return true;
    	}else{
    		return null;
    	}
    }
	public static function SendNewUserNotification(){
		if(defined('SEND_NEW_USER_NOTIFICATION')){
    		$objMessage = MLCEmailDriver::Compose();
			$objMessage->subject('New ' . __PROJECT_NAME__ . ' User');
			$objMessage->from(POSTMARKAPP_MAIL_FROM_ADDRESS);
			$objMessage->to(__SIGN_UP_EMAIL__);
			$strIpAddress = self::GetRemoteAddr();
			$objMessage->messagePlain(__PROJECT_NAME__ . " : New User: ". self::$objUser->idUser. "\n Addr:" . $strIpAddress . "\n" . $_SERVER['HTTP_USER_AGENT']);
			$objMessage->send();
    	}
	}
    public static function AddRoll($strRollType, $objEntity){
        self::User()->AddRoll($strRollType, $objEntity);
    }
    public static function GetRolls($strRollType = null, $objUser = null){
        if(is_null($objUser)){
            $objUser = self::User();
        }
        if(is_null($objUser)){
            return array();
        }

        $strQuery = sprintf('WHERE idAuthUser = %s', $objUser->IdUser);

        if(!is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }

        $arrRolls =  AuthRoll::Query(
            $strQuery
        );

        return $arrRolls;

    }
    public static function GetRollByEntity(BaseEntity $objEntity, $strRollType = null){
        $strQuery = sprintf(
            'WHERE idAuthUser = %s AND idEntity = %s AND entityType = "%s"',
            $objEntity->getPKey(),
            get_class($objEntity),
            self::IdUser()
        );
        if(is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }
        $objRoll =  AuthRoll::Query(
            $strQuery,
            true
        );
        return $objRoll;

    }
    public static function GetUsersByEntity(BaseEntity $objEntity, $strRollType = null){
        //load rolls by idAuthUser
        $strQuery = sprintf(
            'WHERE entityType = "%s" AND idEntity = %s',
            get_class($objEntity),
            $objEntity->getId()
        );
        if(!is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }
        $arrRolls =  AuthRoll::Query(
            $strQuery
        );
        $arrUsers = array();
        foreach($arrRolls as $intIndex => $objRoll){
            $arrUsers[] = AuthUser::LoadById($objRoll->IdUser);
        }
        return $arrUsers;
    }

    
}
?>