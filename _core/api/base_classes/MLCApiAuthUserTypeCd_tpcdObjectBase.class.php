<?php
/**
* Class and Function List:
* Function list:
* - __call()
* Classes list:
* - MLCApiAuthUserTypeCd_tpcdObjectBase extends MLCApiObjectBase
*/
class MLCApiAuthUserTypeCd_tpcdObjectBase extends MLCApiObjectBase {
    protected $strClassName = 'AuthUserTypeCd_tpcd';
    public function __call($strName, $arrArguments) {
        switch ($strName) {
            default:
                return parent::__call($strName, $arrArguments);
        }
    }
}
