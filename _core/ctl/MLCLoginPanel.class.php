<?php
/* 
 * Handels authentication for certain FFS applications
 */
class MLCLoginPanel extends MJaxPanel{
    protected $strRedirectUrl = "/";
    public $divAlert = null;
    public $txtEmail = null;
    public $txtPass = null;
    public $btnSubmit = null;
    public $btnForgotPass = null;
    public $dlgForgotPass = null;
    public $pnlForgotPass = null;
    public function __construct($objParentObject,$strControlId = null) {
        parent::__construct($objParentObject,$strControlId);
        $this->strTemplate =  __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

        $this->AddCssClass('MLCLoginPanel');

        $this->divAlert = new MJaxPanel($this);
		//$this->divAlert->Text = 'Login';
		
        $this->txtEmail = new MJaxTextBox($this);
		$this->txtEmail->Attr('placeholder','Email');
		$this->txtEmail->AddCssClass('span3');
		
        $this->txtPass = new MJaxTextBox($this);
        $this->txtPass->TextMode = MJaxTextMode::Password;
		$this->txtPass->Attr('placeholder','Password');
        $this->txtPass->AddAction(new MJaxEnterKeyEvent(), new MJaxServerControlAction($this, 'btnSubmit_click'));
		$this->txtPass->AddCssClass('span3');
        
        $this->btnSubmit = new MJaxButton($this);
        $this->btnSubmit->AddAction(new MJaxClickEvent(), new MJaxServerControlAction($this, 'btnSubmit_click'));
		$this->btnSubmit->Text = "Login";
		$this->btnSubmit->AddCssClass('btn');

    }
    public function btnSubmit_click($strFormId, $strControlId, $strActionParameter){
        $strEmail = $this->txtEmail->Text;
		if(!filter_var($strEmail, FILTER_VALIDATE_EMAIL)){
			$this->divAlert->Text = "Email is not valid";
			return;
		}
		
        $strPassword = $this->txtPass->Text;
        
        //Validate some shit
       
        $blnSuccess = MLCAuthDriver::Authenticate($strEmail, $strPassword);
        if($blnSuccess){
        	
           $this->divAlert->Text = "Success";
			
		   $this->objForm->Redirect($this->strRedirectUrl);
        }else{
        	try{
        		$objUser = MLCAuthDriver::CreateUser($strEmail, $strPassword);
				$blnSuccess = MLCAuthDriver::Authenticate($strEmail, $strPassword);
				if($blnSuccess){
					$this->objForm->Redirect($this->strRedirectUrl);
				}else{
					$this->divAlert->Text = "Could not create user";
				}
        	}catch(MLCAuthException $e){
        		$this->divAlert->Text = "Email and Password Do Not Match";
				return false;
        	}
            
        }
	
    }

}
?>
