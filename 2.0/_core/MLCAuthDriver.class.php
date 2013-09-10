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
		self::UpdatePendingInvites($objNUser);
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
        //error_log("Domain:" . self::$strDomain);
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
        return self::User()->AddRoll($strRollType, $objEntity);
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
    public static function GetRollByEntity(BaseEntity $objEntity, $strRollType = null, $blnAllowInvites = false){
        $strQuery = sprintf(
            'WHERE idAuthUser = %s AND idEntity = %s AND entityType = "%s"',
            self::IdUser(),
            $objEntity->getId(),
            get_class($objEntity)
        );
        if(is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }
        if(!$blnAllowInvites){
            $strQuery .= ' AND idAuthUser IS NOT NULL ';
        }
        $objRoll =  AuthRoll::Query(
            $strQuery,
            true
        );
        return $objRoll;

    }
    public static function GetRollsByEntity(BaseEntity $objEntity, $strRollType = null, $blnAllowInvites = false){
        $strQuery = sprintf(
            'WHERE idEntity = %s AND entityType = "%s"',
            $objEntity->getId(),
            get_class($objEntity)
        );
        if(is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }
        if(!$blnAllowInvites){
            $strQuery .= ' AND idAuthUser IS NOT NULL ';
        }
        $arrRolls =  AuthRoll::Query(
            $strQuery
        );
        return $arrRolls;

    }
    public static function GetUsersByEntity(BaseEntity $objEntity, $strRollType = null){

        $arrRolls =  self::GetRollsByEntity($objEntity, $strRollType);

        $arrUsers = array();
        foreach($arrRolls as $intIndex => $objRoll){
            $arrUsers[] = AuthUser::LoadById($objRoll->IdAuthUser);
        }
        return $arrUsers;
    }
    public static function IniviteUserToRoll($mixUser, $objEntity, $strRollType){
        $objUser = null;
        $blnValidEmail = false;
        if(
            (is_object($mixUser)) &&
            ($mixUser instanceof AuthUser)
        ){
            $objUser = $mixUser;
        }elseif(
            (is_string($mixUser)) &&
            (filter_var($mixUser, FILTER_VALIDATE_EMAIL))
        ){
            $blnValidEmail = true;
            $objUser = AuthUser::LoadSingleByField('email', $mixUser);
        }
        if(!is_null($objUser)){
            //Just add the roll
            return $objUser->AddRoll($strRollType, $objEntity);
        }elseif(!$blnValidEmail){
            throw new Exception("Not a valid email address");
        }else{

            $objRoll = AuthRoll::Query(
                sprintf(
                    ' WHERE inviteEmail = "%s" AND idEntity = %s AND entityType = "%s" AND rollType = "%s"',
                    $mixUser,
                    $objEntity->getId(),
                    get_class($objEntity),
                    $strRollType
                ),
                true
            );
            if(is_null($objRoll)){
                $objRoll = new AuthRoll();
            }
            $objRoll->SetEntity($objEntity);
            $objRoll->RollType = $strRollType;
            $objRoll->CreDate = MLCDateTime::Now();
            $objRoll->InviteEmail = $mixUser;
            $objRoll->InviteToken = md5('pepper' + rand(0,9999) + 'salt') . '-' . time();
            $objRoll->IdInviteUser = self::IdUser();
            $objRoll->Save();
            return $objRoll;
        }
    }
    public static function UpdatePendingInvites($mixUser = null){
        $arrRolls = null;
        $strField = 'inviteEmail';
        if(is_null($mixUser)){
            if(is_string($mixUser)){
                $strOldEmail = $mixUser;
                if(!filter_var($mixUser, FILTER_VALIDATE_EMAIL)){
                    $strField = 'inviteToken';
                }
            }elseif(is_object($mixUser)){
                if($mixUser instanceof AuthUser){
                    $strOldEmail = $mixUser->Email;
                }elseif($mixUser instanceof AuthRoll){
                    $arrRolls = array($mixUser);
                }else{
                    throw new MLCWrongTypeException('UpdatePendingInvites', $mixUser);
                }
            }
        }else{
            $strOldEmail = $mixUser->Email;
        }
        if(is_null($arrRolls)){
            //load rolls w/o user by email
            $arrRolls = AuthRoll::Query(
                sprintf(
                    'WHERE %s = "%s" AND idAuthUser IS NULL',
                    $strField,
                    $strOldEmail
                )
            );
        }
        foreach($arrRolls as $intIndex => $objRoll){
            $objRoll->IdUser = self::IdUser();
            $objRoll->Save();
        }

    }

    
}
?>