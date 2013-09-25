<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthUserSettingListPanelBase.class.php");
class AuthUserSettingListPanel extends AuthUserSettingListPanelBase {

    public function __construct($objParentControl, $arrAuthUserSettings = array()){

		parent::__construct($objParentControl, $arrAuthUserSettings = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idUserSetting','idUserSetting');
            
            
        
            
            
            $this->AddColumn('idUser','idUser');
            
        
            
            
            $this->AddColumn('idUserSettingTypeCd','idUserSettingTypeCd');
            
        
            
            
            $this->AddColumn('data','data');
            
        
            
            
            $this->AddColumn('namespace','namespace');
            
        
    }
    */


}


?>