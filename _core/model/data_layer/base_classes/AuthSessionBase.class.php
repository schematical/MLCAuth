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
* - GetTrackingEventArr()
* - LoadCollByIdUser()
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
* - AuthSessionBase extends MLCBaseEntity
*/
/**
 * Class Competition
 * @property-read mixed $IdSession
 * @property-write mixed $IdSession
 * @property-read mixed $StartDate
 * @property-write mixed $StartDate
 * @property-read mixed $EndDate
 * @property-write mixed $EndDate
 * @property-read mixed $IdUser
 * @property-write mixed $IdUser
 * @property-read mixed $SessionKey
 * @property-write mixed $SessionKey
 * @property-read mixed $IpAddress
 * @property-write mixed $IpAddress
 * @property-read AuthSession $IdUserObject
 */
class AuthSessionBase extends MLCBaseEntity {
    const DB_CONN = 'DB_0';
    const TABLE_NAME = 'AuthSession';
    const P_KEY = 'idSession';
    protected $objIdUser = null;
    public function __construct() {
        $this->table = DB_PREFIX . self::TABLE_NAME;
        $this->pKey = self::P_KEY;
        $this->strDBConn = self::DB_CONN;
    }
    public static function LoadById($intId) {
        return self::Query('WHERE AuthSession.idSession = ' . $intId, true);
    }
    public static function LoadAll() {
        $coll = self::Query('');
        return $coll;
    }
    public function ToXml($blnReclusive = false) {
        $xmlStr = "";
        $xmlStr.= "<AuthSession>";
        $xmlStr.= "<idSession>";
        $xmlStr.= $this->idSession;
        $xmlStr.= "</idSession>";
        $xmlStr.= "<startDate>";
        $xmlStr.= $this->startDate;
        $xmlStr.= "</startDate>";
        $xmlStr.= "<endDate>";
        $xmlStr.= $this->endDate;
        $xmlStr.= "</endDate>";
        $xmlStr.= "<idUser>";
        $xmlStr.= $this->idUser;
        $xmlStr.= "</idUser>";
        $xmlStr.= "<sessionKey>";
        $xmlStr.= $this->sessionKey;
        $xmlStr.= "</sessionKey>";
        $xmlStr.= "<ipAddress>";
        $xmlStr.= $this->ipAddress;
        $xmlStr.= "</ipAddress>";
        if ($blnReclusive) {
            //Finish FK Rel stuff
            
        }
        $xmlStr.= "</AuthSession>";
        return $xmlStr;
    }
    public function Materilize($arrData) {
        if (isset($arrData) && (sizeof($arrData) > 1)) {
            if ((array_key_exists('AuthSession.idSession', $arrData))) {
                //New Smart Way
                $this->arrDBFields['idSession'] = $arrData['AuthSession.idSession'];
                $this->arrDBFields['startDate'] = $arrData['AuthSession.startDate'];
                $this->arrDBFields['endDate'] = $arrData['AuthSession.endDate'];
                $this->arrDBFields['idUser'] = $arrData['AuthSession.idUser'];
                $this->arrDBFields['sessionKey'] = $arrData['AuthSession.sessionKey'];
                $this->arrDBFields['ipAddress'] = $arrData['AuthSession.ipAddress'];
                //Foregin Key
                if ((array_key_exists('AuthUser.idUser', $arrData)) && (!is_null($arrData['AuthUser.idUser']))) {
                    $this->objIdUser = new AuthUser();
                    $this->objIdUser->Materilize($arrData);
                }
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
        $arrFields[] = 'AuthSession.idSession ' . (($blnLongSelect) ? ' as "AuthSession.idSession"' : '');
        $arrFields[] = 'AuthSession.startDate ' . (($blnLongSelect) ? ' as "AuthSession.startDate"' : '');
        $arrFields[] = 'AuthSession.endDate ' . (($blnLongSelect) ? ' as "AuthSession.endDate"' : '');
        $arrFields[] = 'AuthSession.idUser ' . (($blnLongSelect) ? ' as "AuthSession.idUser"' : '');
        $arrFields[] = 'AuthSession.sessionKey ' . (($blnLongSelect) ? ' as "AuthSession.sessionKey"' : '');
        $arrFields[] = 'AuthSession.ipAddress ' . (($blnLongSelect) ? ' as "AuthSession.ipAddress"' : '');
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
                    case ('AuthUser'):
                        $strJoin.= ' LEFT JOIN AuthUser ON AuthSession.idUser = AuthUser.idUser';
                    break;
                }
            }
        }
        if (!is_null($strExtra)) {
            $strSql = sprintf("SELECT %s FROM AuthSession %s %s;", $strFields, $strJoin, $strExtra);
            $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        }
        if ((is_object($mixReturnSingle)) && ($mixReturnSingle instanceof MLCBaseEntityCollection)) {
            $collReturn = $mixReturnSingle;
            $collReturn->RemoveAll();
        } else {
            $collReturn = new MLCBaseEntityCollection();
            $collReturn->SetQueryEntity('AuthSession');
        }
        if (!is_null($strExtra)) {
            $collReturn->AddQueryToHistory($strSql);
            while ($data = mysql_fetch_assoc($result)) {
                $tObj = new AuthSession();
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
                    case ('AuthUser'):
                        $strJoin.= ' LEFT JOIN AuthUser ON AuthSession.idUser = AuthUser.idUser';
                    break;
                }
            }
        }
        $strSql = sprintf("SELECT %s FROM AuthSession %s %s;", $strFields, $strJoin, $strExtra);
        $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        return mysql_num_rows($result);
    }
    //Get children
    public function GetTrackingEventArr() {
        return TrackingEvent::LoadCollByIdSession($this->idSession)->getCollection();
    }
    //Load by foregin key
    public static function LoadCollByIdUser($intIdUser) {
        $strSql = sprintf(" WHERE idUser = %s;", $intIdUser);
        $coll = self::Query($strSql);
        return $coll;
    }
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
        if (array_key_exists('idsession', $arrData)) {
            $this->intIdSession = $arrData['idsession'];
        }
    }
    public static function Parse($mixData, $blnReturnId = false) {
        if (is_numeric($mixData)) {
            if ($blnReturnId) {
                return $mixData;
            }
            return AuthSession::Load($mixData);
        } elseif ((is_object($mixData)) && (get_class($mixData) == 'AuthSession')) {
            if (!$blnReturnId) {
                return $mixData;
            }
            return $mixData->intIdSession;
        } elseif (is_null($mixData)) {
            return null;
        } else {
            throw new Exception(__FUNCTION__ . ' - Parameter 1 must be either an intiger or a class type "AuthSession"');
        }
    }
    public static function LoadSingleByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthSession.%s %s %s', $strField, $strCompairison, $strValue);
        $objEntity = self::Query($strExtra, true);
        return $objEntity;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthSession.%s %s %s', $strField, $strCompairison, $strValue);
        $arrResults = self::Query($strExtra);
        return $arrResults;
    }
    public function __toArray() {
        $collReturn = array();
        $collReturn['_ClassName'] = "AuthSession %>";
        $collReturn['idSession'] = $this->idSession;
        $collReturn['startDate'] = $this->startDate;
        $collReturn['endDate'] = $this->endDate;
        $collReturn['idUser'] = $this->idUser;
        $collReturn['sessionKey'] = $this->sessionKey;
        $collReturn['ipAddress'] = $this->ipAddress;
        return $collReturn;
    }
    public function __toString() {
        return 'AuthSession(' . $this->getId() . ')';
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
            case ('IdSession'):
            case ('idSession'):
                if (array_key_exists('idSession', $this->arrDBFields)) {
                    return $this->arrDBFields['idSession'];
                }
                return null;
            break;
            case ('StartDate'):
            case ('startDate'):
                if (array_key_exists('startDate', $this->arrDBFields)) {
                    return $this->arrDBFields['startDate'];
                }
                return null;
            break;
            case ('EndDate'):
            case ('endDate'):
                if (array_key_exists('endDate', $this->arrDBFields)) {
                    return $this->arrDBFields['endDate'];
                }
                return null;
            break;
            case ('IdUser'):
            case ('idUser'):
                if (array_key_exists('idUser', $this->arrDBFields)) {
                    return $this->arrDBFields['idUser'];
                }
                return null;
            break;
            case ('SessionKey'):
            case ('sessionKey'):
                if (array_key_exists('sessionKey', $this->arrDBFields)) {
                    return $this->arrDBFields['sessionKey'];
                }
                return null;
            break;
            case ('IpAddress'):
            case ('ipAddress'):
                if (array_key_exists('ipAddress', $this->arrDBFields)) {
                    return $this->arrDBFields['ipAddress'];
                }
                return null;
            break;
            case ('IdUserObject'):
                if (!is_null($this->objIdUser)) {
                    return $this->objIdUser;
                }
                if ((array_key_exists('idUser', $this->arrDBFields)) && (!is_null($this->arrDBFields['idUser']))) {
                    $this->objIdUser = AuthUser::LoadById($this->arrDBFields['idUser']);
                    return $this->objIdUser;
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
            case ('IdSession'):
            case ('idSession'):
                $this->arrDBFields['idSession'] = $mixValue;
            break;
            case ('StartDate'):
            case ('startDate'):
            case ('_StartDate'):
                $this->arrDBFields['startDate'] = $mixValue;
            break;
            case ('EndDate'):
            case ('endDate'):
            case ('_EndDate'):
                $this->arrDBFields['endDate'] = $mixValue;
            break;
            case ('IdUser'):
            case ('idUser'):
                $this->arrDBFields['idUser'] = $mixValue;
                $this->objIdUser = null;
            break;
            case ('SessionKey'):
            case ('sessionKey'):
            case ('_SessionKey'):
                $this->arrDBFields['sessionKey'] = $mixValue;
            break;
            case ('IpAddress'):
            case ('ipAddress'):
            case ('_IpAddress'):
                $this->arrDBFields['ipAddress'] = $mixValue;
            break;
            case ('IdUserObject'):
                if ((!is_null($mixValue)) && ((!is_object($mixValue)) || (!($mixValue instanceof AuthUser)))) {
                    throw new MLCWrongTypeException('__set', $strName);
                }
                if (!is_null($mixValue)) {
                    $this->arrDBFields['idUser'] = $mixValue->idUser;
                } else {
                    $this->arrDBFields['idUser'] = null;
                }
                $this->objIdUser = $mixValue;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
}
?>