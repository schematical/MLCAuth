<?php
/* 
 * A simple panel that triggers an email with a new randomly generated password
 */
class MLCForgotPassPanel extends MJaxPanel{
    public $txtEmail = null;
    public $btnSubmit = null;
    public function __construct($objParentObject,$strControlId = null) {
        parent::__construct($objParentObject,$strControlId);
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';
        $this->AddCssClass('MLCForgotPassPanel');

        $this->txtEmail = new MJaxTextBox($this, $this->strControlId . "txtEmail");
        $this->txtEmail->AddAction(new MJaxEnterKeyEvent(), new MJaxServerControlAction($this, 'btnSubmit_click'));

        $this->btnSubmit = new MJaxButton($this, $this->strControlId . "btnSubmit");
        $this->btnSubmit->Text = "Send New Password";
        $this->btnSubmit->AddAction(new MJaxClickEvent(), new MJaxServerControlAction($this, 'btnSubmit_click'));
    }
    public function btnSubmit_click($strFormId, $strControlId, $strActionParameter){
        $objUser = User::Query('email = ' . $this->txtEmail->Text);
        if(!is_null($objUser)){
            
            $arrVars = array(
                "_EMAIL"=>$objUser->Email,
                "_PASS"=>$objUser->Password,
                "_HASH"=>MLCAuthDriver::HashPass($objUser->Email . $objUser->Password)
            );
            $strEmailBody = MLCAssetDriver::EvaluateTemplate(__FORGOT_PASS_EMAIL__, $arrVars);
            $objMessage = new MJaxEmailMessage($objEmailConfig, $objUser->Email);
            
            MJaxEmailServer::Send($objMessage);
        }

    }
}
?>
