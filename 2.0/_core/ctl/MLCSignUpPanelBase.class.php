<?php
/* 
 * Handels authentication for certain MLC applications
 */
 //Require MJaxBS extension for use
class MLCSignUpPanelBase extends MJaxPanel{
	public $txtUsername = null;
    public $txtEmail = null;
    public $txtPassword1 = null;
    public $txtPassword2 = null;
    public $txtCompanyname = null;
	//public $lstReferal = null;
    //public $txtReferalOther = null;
    public $objInviteRoll = null;

	
    public $lnkSignup = null;
	 public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';
        $this->objInviteRoll = AuthRoll::Query(
            sprintf(
                'WHERE inviteToken = "%s" AND idAuthUser IS NULL',
                MLCApplication::QS(MLCAuthQS::invite_token)
            ),
            true
        );
		$this->CreateControls();
    }
    public function CreateControls() {
        /*$this->lstReferal = new MJaxListBox($this, 'lstReferal', array(
        ));
		$this->lstReferal->AddItem('How did you hear about us?', null);
		$this->lstReferal->AddItem('Other', -1);
		$this->lstReferal->AddAction(
			new MJaxChangeEvent(),
			new MJaxServerControlAction($this, 'lstReferal_change')
		);*/
       
	   
	   	$this->txtUsername = new MJaxTextBox($this, 'txtUsername', array(                        
            "placeholder" => "Username"
        ));
		
        $this->txtUsername->Name = 'Name';
		/*$this->txtUsername->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtUsername_blur')
		);*/
		
		
        $this->txtEmail = new MJaxTextBox($this, 'txtEmail', array(
            "id" => "email",
            "name" => "",
            "type" => "email",
            "placeholder" => "Email"
        ));
        if(!is_null($this->objInviteRoll)){
            $this->txtEmail->Text = $this->objInviteRoll->InviteEmail;
        }
		
        $this->txtEmail->Name = 'email';
		/*$this->txtEmail->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtEmail_blur')
		);*/
		
        $this->txtPassword1 = new MJaxTextBox($this, 'txtPassword1', array(
            "id" => "password1",
            "name" => "",
            "type" => "password",
            "placeholder" => "Password"
        ));
        $this->txtPassword1->Name = 'password1';
		$this->txtPassword1->TextMode = MJaxTextMode::Password;
		//$this->txtPassword1->attr('readonly', 'true');
		/*$this->txtPassword1->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtPassword1_blur')
		);*/
		
        $this->txtPassword2 = new MJaxTextBox($this, 'txtPassword2', array(
            "id" => "password2",
            "name" => "",
            "type" => "",
            "placeholder" => "Retype Password"
        ));
		//$this->txtPassword2->attr('readonly', 'true');
        $this->txtPassword2->Name = 'password2';
		$this->txtPassword2->TextMode = MJaxTextMode::Password;
		/*$this->txtPassword2->AddAction(
			new MJaxBlurEvent(),
			new MJaxServerControlAction($this, 'txtPassword2_blur')
		);*/
		
        $this->txtCompanyname = new MJaxTextBox($this, 'txtCompanyname', array(
            "id" => "companyname",
            "name" => "",
            "type" => "",
            "placeholder" => "Company Name"
        ));
        $this->txtCompanyname->Name = 'companyname';
       /* $this->txtReferalOther = new MJaxTextBox($this, 'txtReferalOther', array(
            "id" => "referalOther",
            "name" => "",
            "type" => "",
            "placeholder" => "Other"
        ));
		$this->txtReferalOther->Style->Display = 'none';
        $this->txtReferalOther->Name = 'referalOther';

*/
        $this->lnkSignup = new MJaxLinkButton($this, 'lnkSignup', array(
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
	/*public function lstReferal_change(){
		if($this->lstReferal->SelectedValue != -1){
			$this->txtReferalOther->Style->Display = 'none';
		}else{
			$this->txtReferalOther->Style->Display = 'inline';
		}
	}*/
	public function txtUsername_blur($strFormId, $strControlId){
		$this->Validate($strControlId);
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
		
		$strUsername = $this->txtUsername->Text;
		if(strlen($strUsername) < 2){
			
			$this->objForm->CtlAlert(
				$this->txtUsername->ControlId . '_holder',
				"Username is not valid"
			);
			$blnValid = false;
		}

		
		$strEmail = $this->txtEmail->Text;
		if(
			($blnValid) &&
			(!filter_var($strEmail, FILTER_VALIDATE_EMAIL))
		){
			if($strControlId != $this->txtUsername->ControlId){
				$this->objForm->CtlAlert(
					$this->txtEmail->ControlId . '_holder',
					"Email is not valid"
				);
				
			}
			$blnValid = false;
		}
		
        $strPassword1 = $this->txtPassword1->Text;
		if(
			($blnValid) &&
			(strlen($strPassword1) < 6)
		){
			if($strControlId != $this->txtEmail->ControlId){
				$this->objForm->CtlAlert(
					$this->txtPassword1->ControlId . '_holder',
					"You need at least 6 charecters"
				);
			}
			$blnValid = false;
		}
		$this->txtPassword2->Attr('readonly', null);
		$strPassword2 = $this->txtPassword2->Text;
		if(
			($blnValid) &&
			($strPassword1 != $strPassword2)
		){
			if($strControlId = $this->txtPassword1->ControlId){
				$this->objForm->CtlAlert(
					$this->txtPassword2->ControlId . '_holder',
					"Your passwords do not match"
				);
			}
			$blnValid = false;
		}
		
		/*if(
			($blnValid) &&
			is_null($this->lstReferal->SelectedValue)
		){
			$this->lstReferal->Alert("Please tell us how you heard of us");
			$blnValid = false;
		}*/
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
				$objUser->Username = $this->txtUsername->Text;
				$objUser->Save();
				$objAccount = MLCAuthDriver::Account();
				$objAccount->ShortDesc = $this->txtCompanyname->Text;
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
        if(!is_null($this->objInviteRoll)){
            MLCAuthDriver::UpdatePendingInvites($this->objInviteRoll);
        }
		$this->blnModified = true;
    	$this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '_success.tpl.php';
		$this->TriggerEvent('auth_signup');
    }
	/*public function AddReferalItem($strDesc, $mixVal){
		$this->lstReferal->AddItem($strDesc, $mixVal);
	}*/
}
?>
