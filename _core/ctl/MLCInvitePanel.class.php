<?php
class MLCInvitePanel extends MJaxPanel{
    public $objEntity = null;
    public $strRollType = null;
    public $txtEmail = null;
    public $lnkInvite = null;


    public function __construct($objParentControl, $objEntity = null, $strRollType = null){
        parent::__construct($objParentControl);
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

        $this->SetEntity($objEntity, $strRollType);

        $this->txtEmail = new MJaxTextBox($this);

        $this->lnkInvite = new MJaxLinkButton($this);
        $this->lnkInvite->AddCssClass('btn');
        $this->lnkInvite->Text = "Invite";
        $this->lnkInvite->AddAction($this, 'lnkInvite_click');

    }
    public function SetEntity($objEntity, $strRollType){
        $this->objEntity = $objEntity;
        $this->strRollType = $strRollType;
        $this->blnModified = true;
    }

    public function lnkInvite_click(){
        $strEmail = $this->txtEmail->Text;
        if(!filter_var($strEmail, FILTER_VALIDATE_EMAIL)){
            return $this->txtEmail->Alert('Invalid email address');
        }

        $objRoll = MLCAuthDriver::IniviteUserToRoll(
            $strEmail,
            $this->objEntity,
            $this->strRollType
        );
        if(!is_null($objRoll)){
            $this->strActionParameter = $objRoll;
            $this->txtEmail->Alert("Invite Sent!", 'success');
            $this->TriggerEvent('mjax-success');
        }else{
            $this->txtEmail->Alert("Invite Failed!", 'error');
            $this->TriggerEvent('mjax-error');
        }
    }
    
}