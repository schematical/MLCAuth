<?php
require_once(__MODEL_APP_CONTROL__ . "/base_classes/AuthUserListPanelBase.class.php");
class AuthUserListPanel extends AuthUserListPanelBase {

    public function __construct($objParentControl, $arrAuthUsers = array()){

		parent::__construct($objParentControl, $arrAuthUsers = array());
        $this->AddCssClass('table table-striped table-bordered');

	}
	/*
	public function SetupCols(){
        
            
            $this->AddColumn('idUser','idUser');
            
            
        
            
            
            $this->AddColumn('email','email');
            
        
            
            
            $this->AddColumn('password','password');
            
        
            
            
            $this->AddColumn('idAccount','idAccount');
            
        
            
            
            $this->AddColumn('idUserTypeCd','idUserTypeCd');
            
        
            
            
            $this->AddColumn('username','username');
            
        
            
            
            $this->AddColumn('passResetCode','passResetCode');
            
        
            
            
            $this->AddColumn('fbuid','fbuid');
            
        
            
            
            $this->AddColumn('fbAccessToken','fbAccessToken');
            
        
            
            
            $this->AddColumn('active','active');
            
        
            
            
            $this->AddColumn('friendsIds','friendsIds');
            
        
            
            
            $this->AddColumn('friendsUpdated','friendsUpdated');
            
        
            
            
            $this->AddColumn('fbAccessTokenExpires','fbAccessTokenExpires');
            
        
    }
    */


}


?>