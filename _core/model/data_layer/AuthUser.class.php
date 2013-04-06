<?php
require_once(__MLC_AUTH_DATA_LAYER__ . "/base_classes/AuthUserBase.class.php");
class AuthUser extends AuthUserBase {

	public function SetUserSetting($strKey, $strData){
		$objSetting = AuthUserSetting::Query(
			sprintf(
				'WHERE idUser = %s AND key = "%s"',
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
		$objSetting->Key = $strKey;
		$objSetting->Value = $strData;
		return $objSetting->Save();
	}
	public function GetUserSetting($strKey){
		$objSetting = AuthUserSetting::Query(
			sprintf(
				'WHERE idUser = %s AND key = "%s"',
				$this->IdUser,
				$strKey
			)
		);
		if(is_null($objSetting)){
			return null;
		}		
		return $objSetting->Key;
	}
}


?>