<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthUserTypeCd_tpcdListPanelBase.class.php");
class AuthUserTypeCd_tpcdListPanel extends AuthUserTypeCd_tpcdListPanelBase {

    public function __construct($objParentControl, $arrAuthUserTypeCd_tpcds = array()){

		parent::__construct($objParentControl, $arrAuthUserTypeCd_tpcds = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idUserTypeCd','idUserTypeCd');
            
            
        
            
            
            $this->AddColumn('shortDesc','shortDesc');
            
        
    }
    */


}


?>