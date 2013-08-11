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
    public static function CreateUser($strEmail, $strPassword, $intIdAccount = null, $intIdUserTypeCd = 3){
        $objNUser = new AuthUser();
        $objNUser->Email = $strEmail;
        $objNUser->Password = self::HashPass($strPassword);
        $objNUser->IdAccount = $intIdAccount;
        $objNUser->IdUserTypeCd = $intIdUserTypeCd;
		$objNUser->Active = 1;
        $objNUser->Save();
        return $objNUser;
    }
    /**
     *Hashes the password using which ever salting/hashing we determin
     *
     * @param <String> $strPassword
     * @return <String>
     */
    public static function HashPass($strPassword){
        return md5(self::PRE_SALT . $strPassword . self::POST_SALT);
    }
    
    /**
     *
     * Takes an email and password and returns true if the user exists and the session was created
     *
     * @param <String> $strEmail
     * @param <String> $strPassword
     * @return <Boolean>
     */
	public static function Authenticate($strEmail, $strPassword, $blnReturnSession = false){
		self::$objUser = User::QuerySingle(
			QQ::AndCondition(
                QQ::Equal(QQN::User()->Email, $strEmail),
                QQ::Equal(QQN::User()->Password, self::HashPass($strPassword)),
                QQ::Equal(QQN::User()->Active, 1)
        	)
		);
        
        if(isset(self::$objUser)){
        	$objSession = self::StartSession(self::$objUser);
        	if($blnReturnSession){
        		return $objSession;
        	}else{
            	return true;
			}
        }else{
            return false;
        }        
		
	}
    /**
     * This function checks the cookies to see if there is an active session for this user
     * and returns the session if there is
     * @return <Session>
     */
    public static function LoadSession(){
        $strSessionKey = MLCCookieDriver::GetCookie(self::SESSION_COOKIE);
        if(!is_null($strSessionKey)){
            $objSession = Session::QuerySingle(
                QQ::Equal(QQN::Session()->SessionKey, $strSessionKey)
            );
            return $objSession;
        }else{
            return null;
        }
    }
    public static function User($blnForceReload = false){
    	if(is_null(self::$objUser) || $blnForceReload){
	        $objSession = self::LoadSession();
	        if(!is_null($objSession)){
	            self::$objUser = $objSession->IdUserObject;
	        }
    	}
    	return self::$objUser;
    }
    public static function IdUserTypeCd(){
        $objUser = self::User();
        if(!is_null($objUser)){
            return $objUser->IdUserTypeCd;
        }else{
            return null;
        }
    }
    public static function IdUser(){
        $objUser = self::User();
        if(!is_null($objUser)){
            return $objUser->IdUser;
        }else{
            return null;
        }
    }
    public static function StartSession($objUser){
        //load any other sessions for that user and kill them
        $arrSessions = Session::QueryArray(
                        QQ::AndCondition(
                            QQ::Equal(QQN::Session()->IdUser, $objUser->IdUser),
                            QQ::LessOrEqual(QQN::Session()->StartDate, QDateTime::Now()),
                            QQ::GreaterOrEqual(QQN::Session()->EndDate, QDateTime::Now())
                        ));
        if(count($arrSessions) > 0){
           
            foreach($arrSessions as $objTSession){
                $objTSession->EndDate = QDateTime::Now();
                $objTSession->Save();
            }
        }

        //
        $objSession = new Session();
        $strName = self::SESSION_COOKIE;
        //here were going to salt the current time with a string
        $strSalt = sprintf("%s%s%s", self::PRE_SALT, time(), self::POST_SALT);
        $strValue = md5($strSalt);
        $objSession->SessionKey = $strValue;
        $objSession->StartDate = QDateTime::Now();
        $dttEndDate = QDateTime::Now();
        $dttEndDate->AddHours(self::SESSION_LENGHT);
        $objSession->EndDate = $dttEndDate;
        $objSession->IpAddress = $_SERVER['REMOTE_ADDR'];
        $objSession->IdUser = $objUser->IdUser;
        $objSession->Save();

        $intExpire = time() + (3600 * self::SESSION_LENGHT);
        MLCCookieDriver::SetCookie($strName, $strValue, $intExpire, self::$strPath, self::$strDomain);
		return $objSession;
    }
    public static function EndSession($objSession = null){
    	if(is_null($objSession)){
        	$objSession = self::LoadSession();
    	}
        MLCCookieDriver::RemoveCookie(self::SESSION_COOKIE, self::$strPath, self::$strDomain);
        if(!is_null($objSession)){
            $objSession->EndDate = QDateTime::Now();
            $objSession->Save();
        }
    }
    public static function GetActiveSession($mixUser, $blnForceEnd = false){
    	if(is_numeric($mixUser)){
    		$objUser = User::Load($mixUser);
    	}elseif(get_class($mixUser) == 'User'){
    		$objUser = $mixUser;
    	}else{
    		throw new Exception("First parameter must be either an Integer or a User object");
    	}
    	$arrSessions = Session::QueryArray(
    		QQ::AndCondition(
    			QQ::Equal(QQN::Session()->IdUser, $objUser->IdUser),
    			QQ::LessOrEqual(QQN::Session()->StartDate, QDateTime::Now()),
    			QQ::GreaterOrEqual(QQN::Session()->EndDate, QDateTime::Now())
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
    
}
?>