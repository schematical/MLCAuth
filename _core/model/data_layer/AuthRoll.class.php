<?php
require_once(__MLC_AUTH_DATA_LAYER__ . "/base_classes/AuthRollBase.class.php");
class AuthRoll extends AuthRollBase {
    public function GetEntity(){
        $objEntity = call_user_func($this->EntityType . '::LoadById', $this->idEntity);
        return $objEntity;
    }
    public function SetEntity(MLCBaseEntity $objEntity ){
        $this->EntityType = get_class($objEntity);
        $this->idEntity = $objEntity->getId();
    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "IdUser":
                return $this->__get('idAuthUser');
            default:
                return parent::__get($strName);
            //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case "IdUser":
                return $this->__set('idAuthUser', $mixValue);
            default:
                return parent::__set($strName, $mixValue);
            //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }

}


?>