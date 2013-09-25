<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* Classes list:
* - AuthUserTypeCdListPanel extends AuthUserTypeCdListPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthUserTypeCdListPanelBase.class.php");
class AuthUserTypeCdListPanel extends AuthUserTypeCdListPanelBase {
    public function __construct($objParentControl, $arrAuthUserTypeCds = array()) {
        parent::__construct($objParentControl, $arrAuthUserTypeCds);
        $this->AddCssClass('table table-striped table-bordered table-condensed');
    }
    /*
    public function SetupCols(){
        
            
            $this->AddColumn('idUserTypeCd','idUserTypeCd');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */
}
?>