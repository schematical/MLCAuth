<?php
require_once(__MLC_AUTH_DATA_LAYER__ . "/base_classes/AuthUserBase.class.php");
class AuthUser extends AuthUserBase {

	public function SetUserSetting($strKey, $strData){
        /*if(array_key_exists($strKey, $this->arrDBFields)){
            return $this->arrDBFields[$strKey] = $strData;
        }*/
		$objSetting = AuthUserSetting::Query(
			sprintf(
				'WHERE idUser = %s AND namespace = "%s"',
				$this->IdUser,
				$strKey
			)
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
}


?>