<?php
/**
* Class and Function List:
* Function list:
* - __call()
* Classes list:
* - MLCApiAuthUserSettingObjectBase extends MLCApiObjectBase
*/
class MLCApiAuthUserSettingObjectBase extends MLCApiObjectBase {
    protected $strClassName = 'AuthUserSetting';
    public function __call($strName, $arrArguments) {
        switch ($strName) {
            default:
                return parent::__call($strName, $arrArguments);
        }
    }
}
