<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthAccountListPanelBase.class.php");
class AuthAccountListPanel extends AuthAccountListPanelBase {

    public function __construct($objParentControl, $arrAuthAccounts = array()){

		parent::__construct($objParentControl, $arrAuthAccounts = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idAccount','idAccount');
            
            
        
            
            
            $this->AddColumn('idAccountTypeCd','idAccountTypeCd');
            
        
            
            
            $this->AddColumn('idUser','idUser');
            
        
            
            
            $this->AddColumn('creDate','creDate');
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */


}


?>