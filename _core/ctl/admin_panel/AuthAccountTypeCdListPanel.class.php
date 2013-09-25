<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* Classes list:
* - AuthAccountTypeCdListPanel extends AuthAccountTypeCdListPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthAccountTypeCdListPanelBase.class.php");
class AuthAccountTypeCdListPanel extends AuthAccountTypeCdListPanelBase {
    public function __construct($objParentControl, $arrAuthAccountTypeCds = array()) {
        parent::__construct($objParentControl, $arrAuthAccountTypeCds);
        $this->AddCssClass('table table-striped table-bordered table-condensed');
    }
    /*
    public function SetupCols(){
        
            
            $this->AddColumn('idAccountTypeCd','idAccountTypeCd');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */
}
?>