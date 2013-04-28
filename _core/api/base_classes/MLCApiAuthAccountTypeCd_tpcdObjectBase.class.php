<?php
/**
* Class and Function List:
* Function list:
* - __call()
* Classes list:
* - MLCApiAuthAccountTypeCd_tpcdObjectBase extends MLCApiObjectBase
*/
class MLCApiAuthAccountTypeCd_tpcdObjectBase extends MLCApiObjectBase {
    protected $strClassName = 'AuthAccountTypeCd_tpcd';
    public function __call($strName, $arrArguments) {
        switch ($strName) {
            default:
                return parent::__call($strName, $arrArguments);
        }
    }
}
