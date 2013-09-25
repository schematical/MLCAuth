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
* - Data()
* Classes list:
* - AuthUserSettingBase extends MLCBaseEntity
*/
/**
 * Class Competition
 * @property-read mixed $IdUserSetting
 * @property-write mixed $IdUserSetting
 * @property-read mixed $IdUser
 * @property-write mixed $IdUser
 * @property-read mixed $IdUserSettingTypeCd
 * @property-write mixed $IdUserSettingTypeCd
 * @property-read mixed $Namespace
 * @property-write mixed $Namespace
 * @property-read AuthUserSetting $IdUserObject
 */
class AuthUserSettingBase extends MLCBaseEntity {
    const DB_CONN = 'DB_0';
    const TABLE_NAME = 'AuthUserSetting';
    const P_KEY = 'idUserSetting';
    protected $objIdUser = null;
    public function __construct() {
        $this->table = DB_PREFIX . self::TABLE_NAME;
        $this->pKey = self::P_KEY;
        $this->strDBConn = self::DB_CONN;
    }
    public static function LoadById($intId) {
        return self::Query('WHERE AuthUserSetting.idUserSetting = ' . $intId, true);
    }
    public static function LoadAll() {
        $coll = self::Query('');
        return $coll;
    }
    public function ToXml($blnReclusive = false) {
        $xmlStr = "";
        $xmlStr.= "<AuthUserSetting>";
        $xmlStr.= "<idUserSetting>";
        $xmlStr.= $this->idUserSetting;
        $xmlStr.= "</idUserSetting>";
        $xmlStr.= "<idUser>";
        $xmlStr.= $this->idUser;
        $xmlStr.= "</idUser>";
        $xmlStr.= "<idUserSettingTypeCd>";
        $xmlStr.= $this->idUserSettingTypeCd;
        $xmlStr.= "</idUserSettingTypeCd>";
        $xmlStr.= "<data>";
        $xmlStr.= $this->data;
        $xmlStr.= "</data>";
        $xmlStr.= "<namespace>";
        $xmlStr.= $this->namespace;
        $xmlStr.= "</namespace>";
        if ($blnReclusive) {
            //Finish FK Rel stuff
            
        }
        $xmlStr.= "</AuthUserSetting>";
        return $xmlStr;
    }
    public function Materilize($arrData) {
        if (isset($arrData) && (sizeof($arrData) > 1)) {
            if ((array_key_exists('AuthUserSetting.idUserSetting', $arrData))) {
                //New Smart Way
                $this->arrDBFields['idUserSetting'] = $arrData['AuthUserSetting.idUserSetting'];
                $this->arrDBFields['idUser'] = $arrData['AuthUserSetting.idUser'];
                $this->arrDBFields['idUserSettingTypeCd'] = $arrData['AuthUserSetting.idUserSettingTypeCd'];
                $this->arrDBFields['data'] = $arrData['AuthUserSetting.data'];
                $this->arrDBFields['namespace'] = $arrData['AuthUserSetting.namespace'];
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
        $arrFields[] = 'AuthUserSetting.idUserSetting ' . (($blnLongSelect) ? ' as "AuthUserSetting.idUserSetting"' : '');
        $arrFields[] = 'AuthUserSetting.idUser ' . (($blnLongSelect) ? ' as "AuthUserSetting.idUser"' : '');
        $arrFields[] = 'AuthUserSetting.idUserSettingTypeCd ' . (($blnLongSelect) ? ' as "AuthUserSetting.idUserSettingTypeCd"' : '');
        $arrFields[] = 'AuthUserSetting.data ' . (($blnLongSelect) ? ' as "AuthUserSetting.data"' : '');
        $arrFields[] = 'AuthUserSetting.namespace ' . (($blnLongSelect) ? ' as "AuthUserSetting.namespace"' : '');
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
                        $strJoin.= ' LEFT JOIN AuthUser ON AuthUserSetting.idUser = AuthUser.idUser';
                    break;
                }
            }
        }
        if (!is_null($strExtra)) {
            $strSql = sprintf("SELECT %s FROM AuthUserSetting %s %s;", $strFields, $strJoin, $strExtra);
            $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        }
        if ((is_object($mixReturnSingle)) && ($mixReturnSingle instanceof MLCBaseEntityCollection)) {
            $collReturn = $mixReturnSingle;
            $collReturn->RemoveAll();
        } else {
            $collReturn = new MLCBaseEntityCollection();
            $collReturn->SetQueryEntity('AuthUserSetting');
        }
        if (!is_null($strExtra)) {
            $collReturn->AddQueryToHistory($strSql);
            while ($data = mysql_fetch_assoc($result)) {
                $tObj = new AuthUserSetting();
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
                        $strJoin.= ' LEFT JOIN AuthUser ON AuthUserSetting.idUser = AuthUser.idUser';
                    break;
                }
            }
        }
        $strSql = sprintf("SELECT %s FROM AuthUserSetting %s %s;", $strFields, $strJoin, $strExtra);
        $result = MLCDBDriver::Query($strSql, self::DB_CONN);
        return mysql_num_rows($result);
    }
    //Get children
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
    }
    public static function Parse($mixData, $blnReturnId = false) {
        if (is_numeric($mixData)) {
            if ($blnReturnId) {
                return $mixData;
            }
            return AuthUserSetting::Load($mixData);
        } elseif ((is_object($mixData)) && (get_class($mixData) == 'AuthUserSetting')) {
            if (!$blnReturnId) {
                return $mixData;
            }
            return $mixData->intIdUserSetting;
        } elseif (is_null($mixData)) {
            return null;
        } else {
            throw new Exception(__FUNCTION__ . ' - Parameter 1 must be either an intiger or a class type "AuthUserSetting"');
        }
    }
    public static function LoadSingleByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthUserSetting.%s %s %s', $strField, $strCompairison, $strValue);
        $objEntity = self::Query($strExtra, true);
        return $objEntity;
    }
    public static function LoadArrayByField($strField, $mixValue, $strCompairison = '=') {
        if (is_numeric($mixValue)) {
            $strValue = $mixValue;
        } else {
            $strValue = sprintf('"%s"', $mixValue);
        }
        $strExtra = sprintf(' WHERE AuthUserSetting.%s %s %s', $strField, $strCompairison, $strValue);
        $arrResults = self::Query($strExtra);
        return $arrResults;
    }
    public function __toArray() {
        $collReturn = array();
        $collReturn['_ClassName'] = "AuthUserSetting %>";
        $collReturn['idUserSetting'] = $this->idUserSetting;
        $collReturn['idUser'] = $this->idUser;
        $collReturn['idUserSettingTypeCd'] = $this->idUserSettingTypeCd;
        $collReturn['data'] = $this->data;
        $collReturn['namespace'] = $this->namespace;
        return $collReturn;
    }
    public function __toString() {
        return 'AuthUserSetting(' . $this->getId() . ')';
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
            case ('IdUserSetting'):
            case ('idUserSetting'):
                if (array_key_exists('idUserSetting', $this->arrDBFields)) {
                    return $this->arrDBFields['idUserSetting'];
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
            case ('IdUserSettingTypeCd'):
            case ('idUserSettingTypeCd'):
                if (array_key_exists('idUserSettingTypeCd', $this->arrDBFields)) {
                    return $this->arrDBFields['idUserSettingTypeCd'];
                }
                return null;
            break;
            case ('Namespace'):
            case ('namespace'):
                if (array_key_exists('namespace', $this->arrDBFields)) {
                    return $this->arrDBFields['namespace'];
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
            case ('IdUserSetting'):
            case ('idUserSetting'):
                $this->arrDBFields['idUserSetting'] = $mixValue;
            break;
            case ('IdUser'):
            case ('idUser'):
                $this->arrDBFields['idUser'] = $mixValue;
                $this->objIdUser = null;
            break;
            case ('IdUserSettingTypeCd'):
            case ('idUserSettingTypeCd'):
                $this->arrDBFields['idUserSettingTypeCd'] = $mixValue;
            break;
            case ('_Data'):
                $this->arrDBFields['data'] = $mixValue;
            break;
            case ('Namespace'):
            case ('namespace'):
            case ('_Namespace'):
                $this->arrDBFields['namespace'] = $mixValue;
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