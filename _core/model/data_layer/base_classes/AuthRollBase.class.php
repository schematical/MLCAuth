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
* - Data()
* Classes list:
* - AuthRollBase extends MLCBaseEntity
*/
/**
 * Class Competition
 * @property-read mixed $IdAuthRoll
 * @property-write mixed $IdAuthRoll
 * @property-read mixed $IdAuthUser
 * @property-write mixed $IdAuthUser
 * @property-read mixed $IdEntity
 * @property-write mixed $IdEntity
 * @property-read mixed $CreDate
 * @property-write mixed $CreDate
 * @property-read mixed $EntityType
 * @property-write mixed $EntityType
 * @property-read mixed $RollType
 * @property-write mixed $RollType
 * @property-read mixed $InviteEmail
 * @property-write mixed $InviteEmail
 * @property-read mixed $InviteToken
 * @property-write mixed $InviteToken
 * @property-read mixed $IdInviteUser
 * @property-write mixed $IdInviteUser
 */
class AuthRollBase extends MLCBaseEntity {
    const DB_CONN = 'DB_0';
    const TABLE_NAME = 'AuthRoll';
    const P_KEY = 'idAuthRoll';
    public function __construct() {
        $this->table = DB_PREFIX . self::TABLE_NAME;
        $this->pKey = self::P_KEY;
        $this->strDBConn = self::DB_CONN;
    }
    public static function LoadById($intId) {
        return self::Query('WHERE AuthRoll.idAuthRoll = ' . $intId, true);
    }
    public static function LoadAll() {
        $coll = self::Query('');
        return $coll;
    }
    public function ToXml($blnReclusive = false) {
        $xmlStr = "";
        $xmlStr.= "<AuthRoll>";
        $xmlStr.= "<idAuthRoll>";
        $xmlStr.= $this->idAuthRoll;
        $xmlStr.= "</idAuthRoll>";
        $xmlStr.= "<idAuthUser>";
        $xmlStr.= $this->idAuthUser;
        $xmlStr.= "</idAuthUser>";
        $xmlStr.= "<idEntity>";
        $xmlStr.= $this->idEntity;
        $xmlStr.= "</idEntity>";
        $xmlStr.= "<creDate>";
        $xmlStr.= $this->creDate;
        $xmlStr.= "</creDate>";
        $xmlStr.= "<entityType>";
        $xmlStr.= $this->entityType;
        $xmlStr.= "</entityType>";
        $xmlStr.= "<rollType>";
        $xmlStr.= $this->rollType;
        $xmlStr.= "</rollType>";
        $xmlStr.= "<data>";
        $xmlStr.= $this->data;
        $xmlStr.= "</data>";
        $xmlStr.= "<inviteEmail>";
        $xmlStr.= $this->inviteEmail;
        $xmlStr.= "</inviteEmail>";
        $xmlStr.= "<inviteToken>";
        $xmlStr.= $this->inviteToken;
        $xmlStr.= "</inviteToken>";
        $xmlStr.= "<idInviteUser>";
        $xmlStr.= $this->idInviteUser;
        $xmlStr.= "</idInviteUser>";
        if ($blnReclusive) {
            //Finish FK Rel stuff
            
        }
        $xmlStr.= "</AuthRoll>";
        return $xmlStr;
    }
    public function Materilize($arrData) {
        if (isset($arrData) && (sizeof($arrData) > 1)) {
            if ((array_key_exists('AuthRoll.idAuthRoll', $arrData))) {
                //New Smart Way
                $this->arrDBFields['idAuthRoll'] = $arrData['AuthRoll.idAuthRoll'];
                $this->arrDBFields['idAuthUser'] = $arrData['AuthRoll.idAuthUser'];
                $this->arrDBFields['idEntity'] = $arrData['AuthRoll.idEntity'];
                $this->arrDBFields['creDate'] = $arrData['AuthRoll.creDate'];
                $this->arrDBFields['entityType'] = $arrData['AuthRoll.entityType'];
                $this->arrDBFields['rollType'] = $arrData['AuthRoll.rollType'];
                $this->arrDBFields['data'] = $arrData['AuthRoll.data'];
                $this->arrDBFields['inviteEmail'] = $arrData['AuthRoll.inviteEmail'];
                $this->arrDBFields['inviteToken'] = $arrData['AuthRoll.inviteToken'];
                $this->arrDBFields['idInviteUser'] = $arrData['AuthRoll.idInviteUser'];
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
        $arrFields[] = 'AuthRoll.idAuthRoll ' . (($blnLongSelect) ? ' as "AuthRoll.idAuthRoll"' : '');
        $arrFields[] = 'AuthRoll.idAuthUser ' . (($blnLongSelect) ? ' as "AuthRoll.idAuthUser"' : '');
        $arrFields[] = 'AuthRoll.idEntity ' . (($blnLongSelect) ? ' as "AuthRoll.idEntity"' : '');
        $arrFields[] = 'AuthRoll.creDate ' . (($blnLongSelect) ? ' as "AuthRoll.creDate"' : '');
        $arrFields[] = 'AuthRoll.entityType ' . (($blnLongSelect) ? ' as "AuthRoll.entityType"' : '');
        $arrFields[] = 'AuthRoll.rollType ' . (($blnLongSelect) ? ' as "AuthRoll.rollType"' : '');
        $arrFields[] = 'AuthRoll.data ' . (($blnLongSelect) ? ' as "AuthRoll.data"' : '');
        $arrFields[] = 'AuthRoll.inviteEmail ' . (($blnLongSelect) ? ' as "AuthRoll.inviteEmail"' : '');
        $arrFields[] = 'AuthRoll.inviteToken ' . (($blnLongSelect) ? ' as "AuthRoll.inviteToken"' : '');
        $arrFields[] = 'AuthRoll.idInviteUser ' . (($blnLongSelect) ? ' as "AuthRoll.idInviteUser"' : '');
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
            $strSql = sprintf("SELECT %s FROM AuthRoll %s %s;", $strFields, $strJoin, $strExtra);
            $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        }
        if ((is_object($mixReturnSingle)) && ($mixReturnSingle instanceof MLCBaseEntityCollection)) {
            $collReturn = $mixReturnSingle;
            $collReturn->RemoveAll();
        } else {
            $collReturn = new MLCBaseEntityCollection();
            $collReturn->SetQueryEntity('AuthRoll');
        }
        if (!is_null($strExtra)) {
            $collReturn->AddQueryToHistory($strSql);
            while ($data = mysql_fetch_assoc($result)) {
                $tObj = new AuthRoll();
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
        $strSql = sprintf("SELECT %s FROM AuthRoll %s %s;", $strFields, $strJoin, $strExtra);
        $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        return mysql_num_rows($result);
    }
    //Get children
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
    }
    public static function Parse($mixData, $blnReturnId = false) {
        if (is_numeric($mixData)) {
            if ($blnReturnId) {
                return $mixData;
            }
            return AuthRoll::Load($mixData);
        } elseif ((is_object($mixData)) && (get_class($mixData) == 'AuthRoll')) {
            if (!$blnReturnId) {
                return $mixData;
            }
            return $mixData->intIdAuthRoll;
        } elseif (is_null($mixData)) {
            return null;
        } else {
            throw new Exception(__FUNCTION__ . ' - Parameter 1 must be either an intiger or a class type "AuthRoll"');
        }
    }
    public static function LoadSingleByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthRoll.%s %s %s', $strField, $strCompairison, $strValue);
        $objEntity = self::Query($strExtra, true);
        return $objEntity;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthRoll.%s %s %s', $strField, $strCompairison, $strValue);
        $arrResults = self::Query($strExtra);
        return $arrResults;
    }
    public function __toArray() {
        $collReturn = array();
        $collReturn['_ClassName'] = "AuthRoll %>";
        $collReturn['idAuthRoll'] = $this->idAuthRoll;
        $collReturn['idAuthUser'] = $this->idAuthUser;
        $collReturn['idEntity'] = $this->idEntity;
        $collReturn['creDate'] = $this->creDate;
        $collReturn['entityType'] = $this->entityType;
        $collReturn['rollType'] = $this->rollType;
        $collReturn['data'] = $this->data;
        $collReturn['inviteEmail'] = $this->inviteEmail;
        $collReturn['inviteToken'] = $this->inviteToken;
        $collReturn['idInviteUser'] = $this->idInviteUser;
        return $collReturn;
    }
    public function __toString() {
        return 'AuthRoll(' . $this->getId() . ')';
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
            case ('IdAuthRoll'):
            case ('idAuthRoll'):
                if (array_key_exists('idAuthRoll', $this->arrDBFields)) {
                    return $this->arrDBFields['idAuthRoll'];
                }
                return null;
            break;
            case ('IdAuthUser'):
            case ('idAuthUser'):
                if (array_key_exists('idAuthUser', $this->arrDBFields)) {
                    return $this->arrDBFields['idAuthUser'];
                }
                return null;
            break;
            case ('IdEntity'):
            case ('idEntity'):
                if (array_key_exists('idEntity', $this->arrDBFields)) {
                    return $this->arrDBFields['idEntity'];
                }
                return null;
            break;
            case ('CreDate'):
            case ('creDate'):
                if (array_key_exists('creDate', $this->arrDBFields)) {
                    return $this->arrDBFields['creDate'];
                }
                return null;
            break;
            case ('EntityType'):
            case ('entityType'):
                if (array_key_exists('entityType', $this->arrDBFields)) {
                    return $this->arrDBFields['entityType'];
                }
                return null;
            break;
            case ('RollType'):
            case ('rollType'):
                if (array_key_exists('rollType', $this->arrDBFields)) {
                    return $this->arrDBFields['rollType'];
                }
                return null;
            break;
            case ('InviteEmail'):
            case ('inviteEmail'):
                if (array_key_exists('inviteEmail', $this->arrDBFields)) {
                    return $this->arrDBFields['inviteEmail'];
                }
                return null;
            break;
            case ('InviteToken'):
            case ('inviteToken'):
                if (array_key_exists('inviteToken', $this->arrDBFields)) {
                    return $this->arrDBFields['inviteToken'];
                }
                return null;
            break;
            case ('IdInviteUser'):
            case ('idInviteUser'):
                if (array_key_exists('idInviteUser', $this->arrDBFields)) {
                    return $this->arrDBFields['idInviteUser'];
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
            case ('IdAuthRoll'):
            case ('idAuthRoll'):
                $this->arrDBFields['idAuthRoll'] = $mixValue;
            break;
            case ('IdAuthUser'):
            case ('idAuthUser'):
                $this->arrDBFields['idAuthUser'] = $mixValue;
            break;
            case ('IdEntity'):
            case ('idEntity'):
                $this->arrDBFields['idEntity'] = $mixValue;
            break;
            case ('CreDate'):
            case ('creDate'):
            case ('_CreDate'):
                $this->arrDBFields['creDate'] = $mixValue;
            break;
            case ('EntityType'):
            case ('entityType'):
            case ('_EntityType'):
                $this->arrDBFields['entityType'] = $mixValue;
            break;
            case ('RollType'):
            case ('rollType'):
            case ('_RollType'):
                $this->arrDBFields['rollType'] = $mixValue;
            break;
            case ('_Data'):
                $this->arrDBFields['data'] = $mixValue;
            break;
            case ('InviteEmail'):
            case ('inviteEmail'):
            case ('_InviteEmail'):
                $this->arrDBFields['inviteEmail'] = $mixValue;
            break;
            case ('InviteToken'):
            case ('inviteToken'):
            case ('_InviteToken'):
                $this->arrDBFields['inviteToken'] = $mixValue;
            break;
            case ('IdInviteUser'):
            case ('idInviteUser'):
                $this->arrDBFields['idInviteUser'] = $mixValue;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
    public function Data($strKey, $mixData = null) {
        if (is_null($mixData)) {
            if ((!array_key_exists('data', $this->arrDBFields))) {
                return null;
            }
            if ((strlen($this->arrDBFields['data']) < 1)) {
                return null;
            }
            $arrData = json_decode($this->arrDBFields['data'], true);
            if (!array_key_exists($strKey, $arrData)) {
                return null;
            }
            return $arrData[$strKey];
        } else {
            if ((!array_key_exists('data', $this->arrDBFields)) || (strlen($this->arrDBFields['data']) < 1)) {
                $arrData = array();
            } else {
                $arrData = json_decode($this->arrDBFields['data'], true);
            }
            $arrData[$strKey] = $mixData;
            $this->arrDBFields['data'] = json_encode($arrData);
            $this->Save();
        }
    }
}
?>