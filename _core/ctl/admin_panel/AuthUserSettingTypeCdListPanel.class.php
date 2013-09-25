<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* Classes list:
* - AuthUserSettingTypeCdListPanel extends AuthUserSettingTypeCdListPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthUserSettingTypeCdListPanelBase.class.php");
class AuthUserSettingTypeCdListPanel extends AuthUserSettingTypeCdListPanelBase {
    public function __construct($objParentControl, $arrAuthUserSettingTypeCds = array()) {
        parent::__construct($objParentControl, $arrAuthUserSettingTypeCds);
        $this->AddCssClass('table table-striped table-bordered table-condensed');
    }
    /*
    public function SetupCols(){
        
            
            $this->AddColumn('idUserSettingType','idUserSettingType');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */
}
?>