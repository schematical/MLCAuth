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
* - GetMLCLocationArr()
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
* - AuthAccountBase extends MLCBaseEntity
*/
/**
 * Class Competition
 * @property-read mixed $IdAccount
 * @property-write mixed $IdAccount
 * @property-read mixed $IdAccountTypeCd
 * @property-write mixed $IdAccountTypeCd
 * @property-read mixed $IdUser
 * @property-write mixed $IdUser
 * @property-read mixed $CreDate
 * @property-write mixed $CreDate
 * @property-read mixed $ShortDesc
 * @property-write mixed $ShortDesc
 */
class AuthAccountBase extends MLCBaseEntity {
    const DB_CONN = 'DB_0';
    const TABLE_NAME = 'AuthAccount';
    const P_KEY = 'idAccount';
    public function __construct() {
        $this->table = DB_PREFIX . self::TABLE_NAME;
        $this->pKey = self::P_KEY;
        $this->strDBConn = self::DB_CONN;
    }
    public static function LoadById($intId) {
        return self::Query('WHERE AuthAccount.idAccount = ' . $intId, true);
    }
    public static function LoadAll() {
        $coll = self::Query('');
        return $coll;
    }
    public function ToXml($blnReclusive = false) {
        $xmlStr = "";
        $xmlStr.= "<AuthAccount>";
        $xmlStr.= "<idAccount>";
        $xmlStr.= $this->idAccount;
        $xmlStr.= "</idAccount>";
        $xmlStr.= "<idAccountTypeCd>";
        $xmlStr.= $this->idAccountTypeCd;
        $xmlStr.= "</idAccountTypeCd>";
        $xmlStr.= "<idUser>";
        $xmlStr.= $this->idUser;
        $xmlStr.= "</idUser>";
        $xmlStr.= "<creDate>";
        $xmlStr.= $this->creDate;
        $xmlStr.= "</creDate>";
        $xmlStr.= "<shortDesc>";
        $xmlStr.= $this->shortDesc;
        $xmlStr.= "</shortDesc>";
        if ($blnReclusive) {
            //Finish FK Rel stuff
            
        }
        $xmlStr.= "</AuthAccount>";
        return $xmlStr;
    }
    public function Materilize($arrData) {
        if (isset($arrData) && (sizeof($arrData) > 1)) {
            if ((array_key_exists('AuthAccount.idAccount', $arrData))) {
                //New Smart Way
                $this->arrDBFields['idAccount'] = $arrData['AuthAccount.idAccount'];
                $this->arrDBFields['idAccountTypeCd'] = $arrData['AuthAccount.idAccountTypeCd'];
                $this->arrDBFields['idUser'] = $arrData['AuthAccount.idUser'];
                $this->arrDBFields['creDate'] = $arrData['AuthAccount.creDate'];
                $this->arrDBFields['shortDesc'] = $arrData['AuthAccount.shortDesc'];
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
        $arrFields[] = 'AuthAccount.idAccount ' . (($blnLongSelect) ? ' as "AuthAccount.idAccount"' : '');
        $arrFields[] = 'AuthAccount.idAccountTypeCd ' . (($blnLongSelect) ? ' as "AuthAccount.idAccountTypeCd"' : '');
        $arrFields[] = 'AuthAccount.idUser ' . (($blnLongSelect) ? ' as "AuthAccount.idUser"' : '');
        $arrFields[] = 'AuthAccount.creDate ' . (($blnLongSelect) ? ' as "AuthAccount.creDate"' : '');
        $arrFields[] = 'AuthAccount.shortDesc ' . (($blnLongSelect) ? ' as "AuthAccount.shortDesc"' : '');
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
            $strSql = sprintf("SELECT %s FROM AuthAccount %s %s;", $strFields, $strJoin, $strExtra);
            $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        }
        if ((is_object($mixReturnSingle)) && ($mixReturnSingle instanceof MLCBaseEntityCollection)) {
            $collReturn = $mixReturnSingle;
            $collReturn->RemoveAll();
        } else {
            $collReturn = new MLCBaseEntityCollection();
            $collReturn->SetQueryEntity('AuthAccount');
        }
        if (!is_null($strExtra)) {
            $collReturn->AddQueryToHistory($strSql);
            while ($data = mysql_fetch_assoc($result)) {
                $tObj = new AuthAccount();
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
        $strSql = sprintf("SELECT %s FROM AuthAccount %s %s;", $strFields, $strJoin, $strExtra);
        $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        return mysql_num_rows($result);
    }
    //Get children
    public function GetMLCLocationArr() {
        return MLCLocation::LoadCollByIdAccount($this->idAccount)->getCollection();
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
        if (array_key_exists('idaccount', $arrData)) {
            $this->intIdAccount = $arrData['idaccount'];
        }
    }
    public static function Parse($mixData, $blnReturnId = false) {
        if (is_numeric($mixData)) {
            if ($blnReturnId) {
                return $mixData;
            }
            return AuthAccount::Load($mixData);
        } elseif ((is_object($mixData)) && (get_class($mixData) == 'AuthAccount')) {
            if (!$blnReturnId) {
                return $mixData;
            }
            return $mixData->intIdAccount;
        } elseif (is_null($mixData)) {
            return null;
        } else {
            throw new Exception(__FUNCTION__ . ' - Parameter 1 must be either an intiger or a class type "AuthAccount"');
        }
    }
    public static function LoadSingleByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthAccount.%s %s %s', $strField, $strCompairison, $strValue);
        $objEntity = self::Query($strExtra, true);
        return $objEntity;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthAccount.%s %s %s', $strField, $strCompairison, $strValue);
        $arrResults = self::Query($strExtra);
        return $arrResults;
    }
    public function __toArray() {
        $collReturn = array();
        $collReturn['_ClassName'] = "AuthAccount %>";
        $collReturn['idAccount'] = $this->idAccount;
        $collReturn['idAccountTypeCd'] = $this->idAccountTypeCd;
        $collReturn['idUser'] = $this->idUser;
        $collReturn['creDate'] = $this->creDate;
        $collReturn['shortDesc'] = $this->shortDesc;
        return $collReturn;
    }
    public function __toString() {
        return 'AuthAccount(' . $this->getId() . ')';
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
            case ('IdAccount'):
            case ('idAccount'):
                if (array_key_exists('idAccount', $this->arrDBFields)) {
                    return $this->arrDBFields['idAccount'];
                }
                return null;
            break;
            case ('IdAccountTypeCd'):
            case ('idAccountTypeCd'):
                if (array_key_exists('idAccountTypeCd', $this->arrDBFields)) {
                    return $this->arrDBFields['idAccountTypeCd'];
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
            case ('CreDate'):
            case ('creDate'):
                if (array_key_exists('creDate', $this->arrDBFields)) {
                    return $this->arrDBFields['creDate'];
                }
                return null;
            break;
            case ('ShortDesc'):
            case ('shortDesc'):
                if (array_key_exists('shortDesc', $this->arrDBFields)) {
                    return $this->arrDBFields['shortDesc'];
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
            case ('IdAccount'):
            case ('idAccount'):
                $this->arrDBFields['idAccount'] = $mixValue;
            break;
            case ('IdAccountTypeCd'):
            case ('idAccountTypeCd'):
                $this->arrDBFields['idAccountTypeCd'] = $mixValue;
            break;
            case ('IdUser'):
            case ('idUser'):
                $this->arrDBFields['idUser'] = $mixValue;
            break;
            case ('CreDate'):
            case ('creDate'):
            case ('_CreDate'):
                $this->arrDBFields['creDate'] = $mixValue;
            break;
            case ('ShortDesc'):
            case ('shortDesc'):
            case ('_ShortDesc'):
                $this->arrDBFields['shortDesc'] = $mixValue;
            break;
            default:
                throw new MLCMissingPropertyException($this, $strName);
            break;
        }
    }
}
?>