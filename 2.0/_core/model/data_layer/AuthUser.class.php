<?php
require_once(__MLC_AUTH_DATA_LAYER__ . "/base_classes/AuthUserBase.class.php");
class AuthUser extends AuthUserBase {
    public static function QueryByUserSetting($strKey, $strValue){

        $objSetting = AuthUserSetting::Query(
            sprintf(
                'WHERE namespace = "%s" AND data = "%s"',
                $strKey,
                $strValue
            ),
            true
        );
        if(is_null($objSetting)){
           return null;
        }
        $objUser = AuthUser::LoadById($objSetting->IdUser);
        return $objUser;
    }
	public function SetUserSetting($strKey, $strData){
        /*if(array_key_exists($strKey, $this->arrDBFields)){
            return $this->arrDBFields[$strKey] = $strData;
        }*/
		$objSetting = AuthUserSetting::Query(
			sprintf(
				'WHERE idUser = %s AND namespace = "%s"',
				$this->IdUser,
				$strKey
			),
            true
		);
		if(is_null($objSetting)){
			$objSetting = new AuthUserSetting();
			$objSetting->IdUser = $this->IdUser;
		}
		if(is_null($strData)){
			return $objSetting->markDeleted();
		}
		$objSetting->Namespace = $strKey;
		$objSetting->Data = $strData;
		return $objSetting->Save();
	}
	public function GetUserSetting($strKey){
        /*if(array_key_exists($strKey, $this->arrDBFields)){
            return $this->arrDBFields[$strKey];
        }*/
		$objSetting = AuthUserSetting::Query(
        //die(
			sprintf(
				'WHERE idUser = %s AND namespace = "%s"',
				$this->IdUser,
				$strKey
			),
            true
		);

		if(is_null($objSetting)){
			return null;
		}		
		return $objSetting->Data;
	}
    public function AddRoll($strRollType, $objEntity){
        $objRoll = MLCAuthDriver::GetRolls($strRollType, $this);
        if(is_null($objRoll)){
            return $objRoll;
        }
        $objRoll = new AuthRoll();
        $objRoll->IdAuthUser = $this->IdUser;
        $objRoll->SetEntity($objEntity);
        $objRoll->RollType = $strRollType;
        $objRoll->CreDate = MLCDateTime::Now();
        $objRoll->Save();
        return $objRoll;
    }
    public function HasRoll($objEntity, $strRollType){
        if(count($this->GetUserRollByEntity($objEntity, $strRollType) > 0)){
            return true;
        }
        return false;
    }
    public function GetUserRollByEntity($objEntity, $strRollType = null){
        $strQuery = sprintf(
            'WHERE entityType = "%s" AND idEntity = %s AND idAuthUser = %s',
            get_class($objEntity),
            $objEntity->getId(),
            $this->getId()
        );
        if(!is_null($strRollType)){
            $strQuery .= sprintf(' AND rollType = "%s"', $strRollType);
        }
        $arrRolls =  AuthRoll::Query(
            $strQuery
        );
        return $arrRolls;
    }
}


?>