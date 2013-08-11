<?php
require_once(__MLC_AUTH_DATA_LAYER__ . "/base_classes/AuthRollBase.class.php");
class AuthRoll extends AuthRollBase {
    public function GetEntity(){
        $objEntity = call_user_func($this->EntityType . '::LoadById', $this->idEntity);
        return $objEntity;
    }
    public function SetEntity(BaseEntity $objEntity ){
        $this->EntityType = get_class($objEntity);
        $this->idEntity = $objEntity->getId();
    }

}


?>