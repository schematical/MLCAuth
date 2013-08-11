<?php
/* 
 * Handels authentication for certain MLC applications
 */
 //Require MJaxBS extension for use
class MLCShortSignUpPanel extends MJaxPanel{
    public $txtEmail = null;
    public $txtPassword1 = null;
    public $txtPassword2 = null;


	
    public $lnkSignup = null;
	 public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';
		$this->CreateControls();
         $this->objForm->SkipMainWindowRender = true;


    }
    public function CreateControls() {

		
        $this->txtEmail = new MJaxTextBox($this, null, array(
            "name" => "",
            "type" => "email",
            "placeholder" => "Email"
        ));
		
        $this->txtEmail->Name = 'email';
		$this->txtEmail->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtEmail_blur')
		);
        //$this->txtEmail->attr('tabindex', '1');

        $this->txtPassword1 = new MJaxTextBox($this, null, array(
            "name" => "",
            "type" => "password",
            "placeholder" => "Password"
        ));
        $this->txtPassword1->Name = 'password1';
		$this->txtPassword1->TextMode = MJaxTextMode::Password;
		//$this->txtPassword1->attr('tabindex', '2');
		$this->txtPassword1->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtPassword1_blur')
		);
		
        $this->txtPassword2 = new MJaxTextBox($this, null, array(
            "name" => "",
            "type" => "",
            "placeholder" => "Retype Password"
        ));
		//$this->txtPassword2->attr('readonly', 'true');
        $this->txtPassword2->Name = 'password2';
		$this->txtPassword2->TextMode = MJaxTextMode::Password;
		$this->txtPassword2->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtPassword2_blur')
		);
        //$this->txtPassword2->attr('tabindex', '3');
		


        $this->lnkSignup = new MJaxLinkButton($this, null, array(
            "id" => "signup",
            "class" => "btn btn-large",
            "href" => "#"
        ));
        $this->lnkSignup->Name = 'signup';
        $this->lnkSignup->AddCssClass('btn btn-large');
		$this->lnkSignup->AddCssClass('disabled');
        $this->lnkSignup->Text = 'Sign Up';
        $this->lnkSignup->AddAction($this, 'lnkSignup_click');
    }
    public function MakeTwoCol(){
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/MLCSignUpPanel_twoCol.tpl.php';
    }

	public function txtEmail_blur($strFormId, $strControlId){
		$this->Validate($strControlId);
	}
	public function txtPassword1_blur($strFormId, $strControlId){
		$this->Validate($strControlId);
	}
	public function txtPassword2_blur($strFormId, $strControlId){
		$this->Validate($strControlId);
	}
	public function Validate($strControlId = null){
		$this->objForm->ClearCtlAlerts();
		$blnValid = true;
		

		
		$strEmail = $this->txtEmail->Text;
		if(
			($blnValid) &&
			(!filter_var($strEmail, FILTER_VALIDATE_EMAIL))
		){


            $this->objForm->CtlAlert(
                $this->txtEmail,
                "Email is not valid"
            );
			$blnValid = false;
		}

        $strPassword1 = $this->txtPassword1->Text;
		if(
			($blnValid) &&
			(strlen($strPassword1) < 6)
		){
            //_dv($strControlId  . '!=' .  $this->txtEmail->ControlId);
			if($strControlId != $this->txtEmail->ControlId){
				$this->objForm->CtlAlert(
					$this->txtPassword1, 
					"You need at least 6 charecters"
				);
			}
			$blnValid = false;
		}
		//$this->txtPassword2->Attr('readonly', null);
		$strPassword2 = $this->txtPassword2->Text;
		if(
			($blnValid) &&
			($strPassword1 != $strPassword2)
		){

			if($strControlId != $this->txtPassword1->ControlId){
				$this->objForm->CtlAlert(
					$this->txtPassword2, 
					"Your passwords do not match"
				);
			}
			$blnValid = false;
		}
		

		return $blnValid;
        
	}
    public function lnkSignup_click($strFormId, $strControlId, $mixActionParam) {
    	if(!$this->Validate()){
    		return false;
    	}
       
	    $strEmail = $this->txtEmail->Text;
        $strPassword1 = $this->txtPassword1->Text;
    	try{
    		$objUser = MLCAuthDriver::CreateUser($strEmail, $strPassword1);
			$blnSuccess = MLCAuthDriver::Authenticate($strEmail, $strPassword1);
			if($blnSuccess){
				//$objUser->Username = $this->txtUsername->Text;
				$objUser->Save();
				$objAccount = MLCAuthDriver::Account();
				//$objAccount->ShortDesc = $this->txtCompanyname->Text;
				$objAccount->Save();
				
			}else{
				$this->objForm->CtlAlert(
					$this->lnkSignup, 
					"Could not login as the user you created"
				);
				return false;
			}
    	}catch(MLCAuthException $e){
			$this->objForm->CtlAlert(
				$this->lnkSignup, 
				$e->getMessage()
			);
			return false;
    	}
		$this->blnModified = true;
    	$this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '_success.tpl.php';
		$this->TriggerEvent('auth_signup');
    }
	public function AddReferalItem($strDesc, $mixVal){
		$this->lstReferal->AddItem($strDesc, $mixVal);
	}
}
?>
