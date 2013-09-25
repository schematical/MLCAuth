<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - LoadById()
* - LoadAll()
* - ToXml()
* - Materilize()
* - GetSQLSelectFieldsAsArr()
* - Query()
* - QueryCount()
* - GetAuthSessionArr()
* - GetAuthUserSettingArr()
* - GetMLCNotificationArr()
* - LoadByTag()
* - AddTag()
* - ParseArray()
* - Parse()
* - LoadSingleByField()
* - LoadArrayByField()
* - __toArray()
* - __toString()
* - __toJson()
* - __get()
* - __set()
* Classes list:
* - AuthUserBase extends MLCBaseEntity
*/
/**
 * Class Competition
 * @property-read mixed $IdUser
 * @property-write mixed $IdUser
 * @property-read mixed $Email
 * @property-write mixed $Email
 * @property-read mixed $Password
 * @property-write mixed $Password
 * @property-read mixed $IdAccount
 * @property-write mixed $IdAccount
 * @property-read mixed $IdUserTypeCd
 * @property-write mixed $IdUserTypeCd
 * @property-read mixed $Username
 * @property-write mixed $Username
 * @property-read mixed $PassResetCode
 * @property-write mixed $PassResetCode
 * @property-read mixed $Fbuid
 * @property-write mixed $Fbuid
 * @property-read mixed $FbAccessToken
 * @property-write mixed $FbAccessToken
 * @property-read mixed $Active
 * @property-write mixed $Active
 * @property-read mixed $FriendsIds
 * @property-write mixed $FriendsIds
 * @property-read mixed $FriendsUpdated
 * @property-write mixed $FriendsUpdated
 * @property-read mixed $FbAccessTokenExpires
 * @property-write mixed $FbAccessTokenExpires
 */
class AuthUserBase extends MLCBaseEntity {
    const DB_CONN = 'DB_0';
    const TABLE_NAME = 'AuthUser';
    const P_KEY = 'idUser';
    public function __construct() {
        $this->table = DB_PREFIX . self::TABLE_NAME;
        $this->pKey = self::P_KEY;
        $this->strDBConn = self::DB_CONN;
    }
    public static function LoadById($intId) {
        return self::Query('WHERE AuthUser.idUser = ' . $intId, true);
    }
    public static function LoadAll() {
        $coll = self::Query('');
        return $coll;
    }
    public function ToXml($blnReclusive = false) {
        $xmlStr = "";
        $xmlStr.= "<AuthUser>";
        $xmlStr.= "<idUser>";
        $xmlStr.= $this->idUser;
        $xmlStr.= "</idUser>";
        $xmlStr.= "<email>";
        $xmlStr.= $this->email;
        $xmlStr.= "</email>";
        $xmlStr.= "<password>";
        $xmlStr.= $this->password;
        $xmlStr.= "</password>";
        $xmlStr.= "<idAccount>";
        $xmlStr.= $this->idAccount;
        $xmlStr.= "</idAccount>";
        $xmlStr.= "<idUserTypeCd>";
        $xmlStr.= $this->idUserTypeCd;
        $xmlStr.= "</idUserTypeCd>";
        $xmlStr.= "<username>";
        $xmlStr.= $this->username;
        $xmlStr.= "</username>";
        $xmlStr.= "<passResetCode>";
        $xmlStr.= $this->passResetCode;
        $xmlStr.= "</passResetCode>";
        $xmlStr.= "<fbuid>";
        $xmlStr.= $this->fbuid;
        $xmlStr.= "</fbuid>";
        $xmlStr.= "<fbAccessToken>";
        $xmlStr.= $this->fbAccessToken;
        $xmlStr.= "</fbAccessToken>";
        $xmlStr.= "<active>";
        $xmlStr.= $this->active;
        $xmlStr.= "</active>";
        $xmlStr.= "<friendsIds>";
        $xmlStr.= $this->friendsIds;
        $xmlStr.= "</friendsIds>";
        $xmlStr.= "<friendsUpdated>";
        $xmlStr.= $this->friendsUpdated;
        $xmlStr.= "</friendsUpdated>";
        $xmlStr.= "<fbAccessTokenExpires>";
        $xmlStr.= $this->fbAccessTokenExpires;
        $xmlStr.= "</fbAccessTokenExpires>";
        if ($blnReclusive) {
            //Finish FK Rel stuff
            
        }
        $xmlStr.= "</AuthUser>";
        return $xmlStr;
    }
    public function Materilize($arrData) {
        if (isset($arrData) && (sizeof($arrData) > 1)) {
            if ((array_key_exists('AuthUser.idUser', $arrData))) {
                //New Smart Way
                $this->arrDBFields['idUser'] = $arrData['AuthUser.idUser'];
                $this->arrDBFields['email'] = $arrData['AuthUser.email'];
                $this->arrDBFields['password'] = $arrData['AuthUser.password'];
                $this->arrDBFields['idAccount'] = $arrData['AuthUser.idAccount'];
                $this->arrDBFields['idUserTypeCd'] = $arrData['AuthUser.idUserTypeCd'];
                $this->arrDBFields['username'] = $arrData['AuthUser.username'];
                $this->arrDBFields['passResetCode'] = $arrData['AuthUser.passResetCode'];
                $this->arrDBFields['fbuid'] = $arrData['AuthUser.fbuid'];
                $this->arrDBFields['fbAccessToken'] = $arrData['AuthUser.fbAccessToken'];
                $this->arrDBFields['active'] = $arrData['AuthUser.active'];
                $this->arrDBFields['friendsIds'] = $arrData['AuthUser.friendsIds'];
                $this->arrDBFields['friendsUpdated'] = $arrData['AuthUser.friendsUpdated'];
                $this->arrDBFields['fbAccessTokenExpires'] = $arrData['AuthUser.fbAccessTokenExpires'];
                //Foregin Key
                
            } else {
                //Old ways
                $this->arrDBFields = $arrData;
            }
            $this->loaded = true;
            $this->setId($this->getField($this->getPKey()));
        }
        if (self::$blnUseCache) {
            if (!array_key_exists(get_class($this) , self::$arrCachedData)) {
                self::$arrCachedData[get_class($this) ] = array();
            }
            self::$arrCachedData[get_class($this) ][$this->getId() ] = $this;
        }
    }
    public static function GetSQLSelectFieldsAsArr($blnLongSelect = false) {
        $arrFields = array();
        $arrFields[] = 'AuthUser.idUser ' . (($blnLongSelect) ? ' as "AuthUser.idUser"' : '');
        $arrFields[] = 'AuthUser.email ' . (($blnLongSelect) ? ' as "AuthUser.email"' : '');
        $arrFields[] = 'AuthUser.password ' . (($blnLongSelect) ? ' as "AuthUser.password"' : '');
        $arrFields[] = 'AuthUser.idAccount ' . (($blnLongSelect) ? ' as "AuthUser.idAccount"' : '');
        $arrFields[] = 'AuthUser.idUserTypeCd ' . (($blnLongSelect) ? ' as "AuthUser.idUserTypeCd"' : '');
        $arrFields[] = 'AuthUser.username ' . (($blnLongSelect) ? ' as "AuthUser.username"' : '');
        $arrFields[] = 'AuthUser.passResetCode ' . (($blnLongSelect) ? ' as "AuthUser.passResetCode"' : '');
        $arrFields[] = 'AuthUser.fbuid ' . (($blnLongSelect) ? ' as "AuthUser.fbuid"' : '');
        $arrFields[] = 'AuthUser.fbAccessToken ' . (($blnLongSelect) ? ' as "AuthUser.fbAccessToken"' : '');
        $arrFields[] = 'AuthUser.active ' . (($blnLongSelect) ? ' as "AuthUser.active"' : '');
        $arrFields[] = 'AuthUser.friendsIds ' . (($blnLongSelect) ? ' as "AuthUser.friendsIds"' : '');
        $arrFields[] = 'AuthUser.friendsUpdated ' . (($blnLongSelect) ? ' as "AuthUser.friendsUpdated"' : '');
        $arrFields[] = 'AuthUser.fbAccessTokenExpires ' . (($blnLongSelect) ? ' as "AuthUser.fbAccessTokenExpires"' : '');
        return $arrFields;
    }
    public static function Query($strExtra = null, $mixReturnSingle = false, $arrJoins = null) {
        $blnLongSelect = !is_null($arrJoins);
        $arrFields = self::GetSQLSelectFieldsAsArr($blnLongSelect);
        if ($blnLongSelect) {
            foreach ($arrJoins as $strTable) {
                if (class_exists($strTable)) {
                    $arrFields = array_merge($arrFields, call_user_func($strTable . '::GetSQLSelectFieldsAsArr', true));
                }
            }
        }
        $strFields = implode(', ', $arrFields);
        $strJoin = '';
        if ($blnLongSelect) {
            foreach ($arrJoins as $strTable) {
                switch ($strTable) {
                }
            }
        }
        if (!is_null($strExtra)) {
            $strSql = sprintf("SELECT %s FROM AuthUser %s %s;", $strFields, $strJoin, $strExtra);
            $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        }
        if ((is_object($mixReturnSingle)) && ($mixReturnSingle instanceof MLCBaseEntityCollection)) {
            $collReturn = $mixReturnSingle;
            $collReturn->RemoveAll();
        } else {
            $collReturn = new MLCBaseEntityCollection();
            $collReturn->SetQueryEntity('AuthUser');
        }
        if (!is_null($strExtra)) {
            $collReturn->AddQueryToHistory($strSql);
            while ($data = mysql_fetch_assoc($result)) {
                $tObj = new AuthUser();
                $tObj->Materilize($data);
                $collReturn[] = $tObj;
            }
        }
        if ($mixReturnSingle !== false) {
            if (count($collReturn) == 0) {
                return null;
            } else {
                return $collReturn[0];
            }
        } else {
            return $collReturn;
        }
    }
    public static function QueryCount($strExtra = '', $arrJoins = array()) {
        $blnLongSelect = !is_null($arrJoins);
        $arrFields = self::GetSQLSelectFieldsAsArr($blnLongSelect);
        if ($blnLongSelect) {
            foreach ($arrJoins as $strTable) {
                if (class_exists($strTable)) {
                    $arrFields = array_merge($arrFields, call_user_func($strTable . '::GetSQLSelectFieldsAsArr', true));
                }
            }
        }
        $strFields = implode(', ', $arrFields);
        $strJoin = '';
        if ($blnLongSelect) {
            foreach ($arrJoins as $strTable) {
                switch ($strTable) {
                }
            }
        }
        $strSql = sprintf("SELECT %s FROM AuthUser %s %s;", $strFields, $strJoin, $strExtra);
        $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        return mysql_num_rows($result);
    }
    //Get children
    public function GetAuthSessionArr() {
        return AuthSession::LoadCollByIdUser($this->idUser)->getCollection();
    }
    public function GetAuthUserSettingArr() {
        return AuthUserSetting::LoadCollByIdUser($this->idUser)->getCollection();
    }
    public function GetMLCNotificationArr() {
        return MLCNotification::LoadCollByIdUser($this->idUser)->getCollection();
    }
    //Load by foregin key
    public function LoadByTag($strTag) {
        return MLCTagDriver::LoadTaggedEntites($strTag, get_class($this));
    }
    public function AddTag($mixTag) {
        return MLCTagDriver::AddTag($mixTag, $this);
    }
    public function ParseArray($arrData) {
        foreach ($arrData as $strKey => $mixVal) {
            $arrData[strtolower($strKey) ] = $mixVal;
        }
        if (array_key_exists('iduser', $arrData)) {
            $this->intIdUser = $arrData['iduser'];
        }
        if (array_key_exists('iduser', $arrData)) {
            $this->intIdUser = $arrData['iduser'];
        }
        if (array_key_exists('iduser', $arrData)) {
            $this->intIdUser = $arrData['iduser'];
        }
    }
    public static function Parse($mixData, $blnReturnId = false) {
        if (is_numeric($mixData)) {
            if ($blnReturnId) {
                return $mixData;
            }
            return AuthUser::Load($mixData);
        } elseif ((is_object($mixData)) && (get_class($mixData) == 'AuthUser')) {
            if (!$blnReturnId) {
                return $mixData;
            }
            return $mixData->intIdUser;
        } elseif (is_null($mixData)) {
            return null;
        } else {
            throw new Exception(__FUNCTION__ . ' - Parameter 1 must be either an intiger or a class type "AuthUser"');
        }
    }
    public static function LoadSingleByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthUser.%s %s %s', $strField, $strCompairison, $strValue);
        $objEntity = self::Query($strExtra, true);
        return $objEntity;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthUser.%s %s %s', $strField, $strCompairison, $strValue);
        $arrResults = self::Query($strExtra);
        return $arrResults;
    }
    public function __toArray() {
        $collReturn = array();
        $collReturn['_ClassName'] = "AuthUser %>";
        $collReturn['idUser'] = $this->idUser;
        $collReturn['email'] = $this->email;
        $collReturn['password'] = $this->password;
        $collReturn['idAccount'] = $this->idAccount;
        $collReturn['idUserTypeCd'] = $this->idUserTypeCd;
        $collReturn['username'] = $this->username;
        $collReturn['passResetCode'] = $this->passResetCode;
        $collReturn['fbuid'] = $this->fbuid;
        $collReturn['fbAccessToken'] = $this->fbAccessToken;
        $collReturn['active'] = $this->active;
        $collReturn['friendsIds'] = $this->friendsIds;
        $collReturn['friendsUpdated'] = $this->friendsUpdated;
        $collReturn['fbAccessTokenExpires'] = $this->fbAccessTokenExpires;
        return $collReturn;
    }
    public function __toString() {
        return 'AuthUser(' . $this->getId() . ')';
    }
    public function __toJson($blnPosponeEncode = false) {
        $collReturn = $this->__toArray();
        if ($blnPosponeEncode) {
            return json_encode($collReturn);
        } else {
            return $collReturn;
        }
    }
    public function __get($strName) {
        switch ($strName) {
            case ('IdUser'):
            case ('idUser'):
                if (array_key_exists('idUser', $this->arrDBFields)) {
                    return $this->arrDBFields['idUser'];
                }
                return null;
            break;
            case ('Email'):
            case ('email'):
                if (array_key_exists('email', $this->arrDBFields)) {
                    return $this->arrDBFields['email'];
                }
                return null;
            break;
            case ('Password'):
            case ('password'):
                if (array_key_exists('password', $this->arrDBFields)) {
                    return $this->arrDBFields['password'];
                }
                return null;
            break;
            case ('IdAccount'):
            case ('idAccount'):
                if (array_key_exists('idAccount', $this->arrDBFields)) {
                    return $this->arrDBFields['idAccount'];
                }
                return null;
            break;
            case ('IdUserTypeCd'):
            case ('idUserTypeCd'):
                if (array_key_exists('idUserTypeCd', $this->arrDBFields)) {
                    return $this->arrDBFields['idUserTypeCd'];
                }
                return null;
            break;
            case ('Username'):
            case ('username'):
                if (array_key_exists('username', $this->arrDBFields)) {
                    return $this->arrDBFields['username'];
                }
                return null;
            break;
            case ('PassResetCode'):
            case ('passResetCode'):
                if (array_key_exists('passResetCode', $this->arrDBFields)) {
                    return $this->arrDBFields['passResetCode'];
                }
                return null;
            break;
            case ('Fbuid'):
            case ('fbuid'):
                if (array_key_exists('fbuid', $this->arrDBFields)) {
                    return $this->arrDBFields['fbuid'];
                }
                return null;
            break;
            case ('FbAccessToken'):
            case ('fbAccessToken'):
                if (array_key_exists('fbAccessToken', $this->arrDBFields)) {
                    return $this->arrDBFields['fbAccessToken'];
                }
                return null;
            break;
            case ('Active'):
            case ('active'):
                if (array_key_exists('active', $this->arrDBFields)) {
                    return $this->arrDBFields['active'];
                }
                return null;
            break;
            case ('FriendsIds'):
            case ('friendsIds'):
                if (array_key_exists('friendsIds', $this->arrDBFields)) {
                    return $this->arrDBFields['friendsIds'];
                }
                return null;
            break;
            case ('FriendsUpdated'):
            case ('friendsUpdated'):
                if (array_key_exists('friendsUpdated', $this->arrDBFields)) {
                    return $this->arrDBFields['friendsUpdated'];
                }
                return null;
            break;
            case ('FbAccessTokenExpires'):
            case ('fbAccessTokenExpires'):
                if (array_key_exists('fbAccessTokenExpires', $this->arrDBFields)) {
                    return $this->arrDBFields['fbAccessTokenExpires'];
                }
                return null;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
    public function __set($strName, $mixValue) {
        $this->modified = 1;
        switch ($strName) {
            case ('IdUser'):
            case ('idUser'):
                $this->arrDBFields['idUser'] = $mixValue;
            break;
            case ('Email'):
            case ('email'):
            case ('_Email'):
                $this->arrDBFields['email'] = $mixValue;
            break;
            case ('Password'):
            case ('password'):
            case ('_Password'):
                $this->arrDBFields['password'] = $mixValue;
            break;
            case ('IdAccount'):
            case ('idAccount'):
                $this->arrDBFields['idAccount'] = $mixValue;
            break;
            case ('IdUserTypeCd'):
            case ('idUserTypeCd'):
                $this->arrDBFields['idUserTypeCd'] = $mixValue;
            break;
            case ('Username'):
            case ('username'):
            case ('_Username'):
                $this->arrDBFields['username'] = $mixValue;
            break;
            case ('PassResetCode'):
            case ('passResetCode'):
            case ('_PassResetCode'):
                $this->arrDBFields['passResetCode'] = $mixValue;
            break;
            case ('Fbuid'):
            case ('fbuid'):
            case ('_Fbuid'):
                $this->arrDBFields['fbuid'] = $mixValue;
            break;
            case ('FbAccessToken'):
            case ('fbAccessToken'):
            case ('_FbAccessToken'):
                $this->arrDBFields['fbAccessToken'] = $mixValue;
            break;
            case ('Active'):
            case ('active'):
            case ('_Active'):
                $this->arrDBFields['active'] = $mixValue;
            break;
            case ('FriendsIds'):
            case ('friendsIds'):
            case ('_FriendsIds'):
                $this->arrDBFields['friendsIds'] = $mixValue;
            break;
            case ('FriendsUpdated'):
            case ('friendsUpdated'):
            case ('_FriendsUpdated'):
                $this->arrDBFields['friendsUpdated'] = $mixValue;
            break;
            case ('FbAccessTokenExpires'):
            case ('fbAccessTokenExpires'):
            case ('_FbAccessTokenExpires'):
                $this->arrDBFields['fbAccessTokenExpires'] = $mixValue;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
}
?>