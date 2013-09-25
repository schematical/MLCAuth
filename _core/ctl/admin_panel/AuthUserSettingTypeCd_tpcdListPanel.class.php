<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthUserSettingTypeCd_tpcdListPanelBase.class.php");
class AuthUserSettingTypeCd_tpcdListPanel extends AuthUserSettingTypeCd_tpcdListPanelBase {

    public function __construct($objParentControl, $arrAuthUserSettingTypeCd_tpcds = array()){

		parent::__construct($objParentControl, $arrAuthUserSettingTypeCd_tpcds = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idUserSettingType','idUserSettingType');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */


}


?>