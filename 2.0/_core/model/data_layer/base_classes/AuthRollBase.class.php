<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - LoadById()
* - LoadAll()
* - ToXml()
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
* Classes list:
* - AuthRollBase extends MLCBaseEntity
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
        $sql = sprintf("SELECT * FROM %s WHERE idAuthRoll = %s;", self::TABLE_NAME, $intId);
        $result = MLCDBDriver::Query($sql, self::DB_CONN);
        while ($data = mysql_fetch_assoc($result)) {
            $tObj = new AuthRoll();
            $tObj->materilize($data);
            return $tObj;
        }
    }
    public static function LoadAll() {
        $sql = sprintf("SELECT * FROM %s;", self::TABLE_NAME);
        $result = MLCDBDriver::Query($sql, AuthRoll::DB_CONN);
        $coll = new MLCBaseEntityCollection();
        while ($data = mysql_fetch_assoc($result)) {
            $tObj = new AuthRoll();
            $tObj->materilize($data);
            $coll->addItem($tObj);
        }
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
    public static function Query($strExtra, $blnReturnSingle = false) {
        $sql = sprintf("SELECT * FROM %s %s;", self::TABLE_NAME, $strExtra);
        $result = MLCDBDriver::Query($sql, self::DB_CONN);
        $coll = new MLCBaseEntityCollection();
        while ($data = mysql_fetch_assoc($result)) {
            $tObj = new AuthRoll();
            $tObj->materilize($data);
            $coll->addItem($tObj);
        }
        $arrReturn = $coll->getCollection();
        if ($blnReturnSingle) {
            if (count($arrReturn) == 0) {
                return null;
            } else {
                return $arrReturn[0];
            }
        } else {
            return $arrReturn;
        }
    }
    public static function QueryCount($strExtra = '') {
        $sql = sprintf("SELECT * FROM %s %s;", self::TABLE_NAME, $strExtra);
        $result = MLCDBDriver::Query($sql, self::DB_CONN);
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
        $arrResults = self::LoadArrayByField($strField, $mixValue, $strCompairison);
        if (count($arrResults)) {
            return $arrResults[0];
        }
        return null;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE %s %s %s', $strField, $strCompairison, $strValue);
        $sql = sprintf("SELECT * FROM %s %s;", self::TABLE_NAME, $strExtra);
        //die($sql);
        $result = MLCDBDriver::query($sql, self::DB_CONN);
        $coll = new MLCBaseEntityCollection();
        while ($data = mysql_fetch_assoc($result)) {
            $tObj = new AuthRoll();
            $tObj->materilize($data);
            $coll->addItem($tObj);
        }
        $arrResults = $coll->getCollection();
        return $arrResults;
    }
    public function __toArray() {
        $arrReturn = array();
        $arrReturn['_ClassName'] = "AuthRoll %>";
        $arrReturn['idAuthRoll'] = $this->idAuthRoll;
        $arrReturn['idAuthUser'] = $this->idAuthUser;
        $arrReturn['idEntity'] = $this->idEntity;
        $arrReturn['creDate'] = $this->creDate;
        $arrReturn['entityType'] = $this->entityType;
        $arrReturn['rollType'] = $this->rollType;
        $arrReturn['data'] = $this->data;
        $arrReturn['inviteEmail'] = $this->inviteEmail;
        $arrReturn['inviteToken'] = $this->inviteToken;
        $arrReturn['idInviteUser'] = $this->idInviteUser;
        return $arrReturn;
    }
    public function __toString() {
        return 'AuthRoll(' . $this->getId() . ')';
    }
    public function __toJson($blnPosponeEncode = false) {
        $arrReturn = $this->__toArray();
        if ($blnPosponeEncode) {
            return json_encode($arrReturn);
        } else {
            return $arrReturn;
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
            case ('Data'):
            case ('data'):
                if (array_key_exists('data', $this->arrDBFields)) {
                    return $this->arrDBFields['data'];
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
    public function __set($strName, $strValue) {
        $this->modified = 1;
        switch ($strName) {
            case ('IdAuthRoll'):
            case ('idAuthRoll'):
                $this->arrDBFields['idAuthRoll'] = $strValue;
            break;
            case ('IdAuthUser'):
            case ('idAuthUser'):
                $this->arrDBFields['idAuthUser'] = $strValue;
            break;
            case ('IdEntity'):
            case ('idEntity'):
                $this->arrDBFields['idEntity'] = $strValue;
            break;
            case ('CreDate'):
            case ('creDate'):
                $this->arrDBFields['creDate'] = $strValue;
            break;
            case ('EntityType'):
            case ('entityType'):
                $this->arrDBFields['entityType'] = $strValue;
            break;
            case ('RollType'):
            case ('rollType'):
                $this->arrDBFields['rollType'] = $strValue;
            break;
            case ('Data'):
            case ('data'):
                $this->arrDBFields['data'] = $strValue;
            break;
            case ('InviteEmail'):
            case ('inviteEmail'):
                $this->arrDBFields['inviteEmail'] = $strValue;
            break;
            case ('InviteToken'):
            case ('inviteToken'):
                $this->arrDBFields['inviteToken'] = $strValue;
            break;
            case ('IdInviteUser'):
            case ('idInviteUser'):
                $this->arrDBFields['idInviteUser'] = $strValue;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
}
?>