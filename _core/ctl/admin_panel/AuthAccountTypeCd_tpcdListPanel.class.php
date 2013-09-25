<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthAccountTypeCd_tpcdListPanelBase.class.php");
class AuthAccountTypeCd_tpcdListPanel extends AuthAccountTypeCd_tpcdListPanelBase {

    public function __construct($objParentControl, $arrAuthAccountTypeCd_tpcds = array()){

		parent::__construct($objParentControl, $arrAuthAccountTypeCd_tpcds = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idAccountTypeCd','idAccountTypeCd');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */


}


?>