<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthSessionListPanelBase.class.php");
class AuthSessionListPanel extends AuthSessionListPanelBase {

    public function __construct($objParentControl, $arrAuthSessions = array()){

		parent::__construct($objParentControl, $arrAuthSessions = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idSession','idSession');
            
            
        
            
            
            $this->AddColumn('startDate','startDate');
            
        
            
            
            $this->AddColumn('endDate','endDate');
            
        
            
            
            $this->AddColumn('idUser','idUser');
            
        
            
            
            $this->AddColumn('sessionKey','sessionKey');
            
        
            
            
            $this->AddColumn('ipAddress','ipAddress');
            
        
    }
    */


}


?>