<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthSession()
* - SetAuthSession()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitIdUserAutocomplete()
* - InitSessionKeyAutocomplete()
* - InitIpAddressAutocomplete()
* Classes list:
* - AuthSessionEditPanelBase extends MJaxPanel
*/
class AuthSessionEditPanelBase extends MJaxPanel {
    protected $objAuthSession = null;
    public $intIdSession = null;
    public $dttStartDate = null;
    public $dttEndDate = null;
    public $intIdUser = null;
    public $strSessionKey = null;
    public $strIpAddress = null;
    public $lnkViewParentIdUser = null;
    public $lnkViewChildTrackingEvent = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthSession = null) {
        parent::__construct($objParentControl);
        $this->objAuthSession = $objAuthSession;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthSessionEditPanelBase.tpl.php';
        $this->CreateFieldControls();
        $this->CreateContentControls();
        $this->CreateReferenceControls();
    }
    public function CreateContentControls() {
        $this->btnSave = new MJaxButton($this);
        $this->btnSave->Text = 'Save';
        $this->btnSave->AddAction(new MJaxClickEvent() , new MJaxServerControlAction($this, 'btnSave_click'));
        $this->btnSave->AddCssClass('btn btn-large');
        $this->btnDelete = new MJaxButton($this);
        $this->btnDelete->Text = 'Delete';
        $this->btnDelete->AddAction(new MJaxClickEvent() , new MJaxServerControlAction($this, 'btnDelete_click'));
        $this->btnDelete->AddCssClass('btn btn-large');
        if (is_null($this->objAuthSession)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        //Is special field!!!!!
        $this->dttStartDate = new MJaxBSDateTimePicker($this);
        //Is special field!!!!!
        $this->dttEndDate = new MJaxBSDateTimePicker($this);
        //Is special field!!!!!
        $this->strSessionKey = new MJaxTextBox($this);
        $this->strSessionKey->Name = 'sessionKey';
        $this->strSessionKey->AddCssClass('input-large');
        //varchar(64)
        $this->strIpAddress = new MJaxTextBox($this);
        $this->strIpAddress->Name = 'ipAddress';
        $this->strIpAddress->AddCssClass('input-large');
        //varchar(16)
        if (!is_null($this->objAuthSession)) {
            $this->SetAuthSession($this->objAuthSession);
        }
    }
    public function GetAuthSession() {
        if (is_null($this->objAuthSession)) {
            //Create a new one
            $this->objAuthSession = new AuthSession();
        }
        //Is special field!!!!!
        $this->objAuthSession->startDate = $this->dttStartDate->GetValue();
        //Is special field!!!!!
        $this->objAuthSession->endDate = $this->dttEndDate->GetValue();
        //Is special field!!!!!
        $this->objAuthSession->idUser = MLCAuthDriver::IdUser();
        if (get_class($this->strSessionKey) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strSessionKey->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('sessionKey');
            }
            $this->objAuthSession->sessionKey = $mixEntity;
        } else {
            $this->objAuthSession->sessionKey = $this->strSessionKey->Text;
        }
        if (get_class($this->strIpAddress) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strIpAddress->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('ipAddress');
            }
            $this->objAuthSession->ipAddress = $mixEntity;
        } else {
            $this->objAuthSession->ipAddress = $this->strIpAddress->Text;
        }
        return $this->objAuthSession;
    }
    public function SetAuthSession($objAuthSession) {
        $this->objAuthSession = $objAuthSession;
        $this->ActionParameter = $this->objAuthSession;
        $this->blnModified = true;
        if (!is_null($this->objAuthSession)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdSession = $this->objAuthSession->idSession;
            //Is special field!!!!!
            $this->dttStartDate->Value = $this->objAuthSession->startDate;
            //Is special field!!!!!
            $this->dttEndDate->Value = $this->objAuthSession->endDate;
            //Is special field!!!!!
            $this->strSessionKey->Text = $this->objAuthSession->sessionKey;
            $this->strIpAddress->Text = $this->objAuthSession->ipAddress;
        } else {
            //Is special field!!!!!
            $this->dttStartDate->Value = MLCDateTime::Now();
            //Is special field!!!!!
            $this->dttEndDate->Value = MLCDateTime::Now();
            //Is special field!!!!!
            $this->strSessionKey->Text = '';
            $this->strIpAddress->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthSession)) {
            if (!is_null($this->objAuthSession->idUser)) {
                $this->lnkViewParentIdUser = new MJaxLinkButton($this);
                $this->lnkViewParentIdUser->Text = 'View AuthUser';
                $this->lnkViewParentIdUser->Href = '/data/editAuthSession?' . FFSQS::AuthSession_IdUser . $this->objAuthSession->idUser;
            }
        }
        $this->lnkViewChildTrackingEvent = new MJaxLinkButton($this);
        $this->lnkViewChildTrackingEvent->Text = 'View TrackingEvents';
        //I should really fix this
        //$this->lnkViewChildTrackingEvent->Href = __ENTITY_MODEL_DIR__ . '/AuthSession/' . $this->objAuthSession->idSession . '/TrackingEvents';
        
    }
    public function btnSave_click() {
        $this->GetAuthSession()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthSession;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthSession->MarkDeleted();
        $this->SetAuthSession(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthSession);
    }
    public function InitIdUserAutocomplete() {
        $this->intIdUser = new MJaxBSAutocompleteTextBox($this);
        $this->intIdUser->SetSearchEntity('authuser');
        $this->intIdUser->Name = 'idUser';
        $this->intIdUser->AddCssClass('input-large');
    }
    public function InitSessionKeyAutocomplete() {
        $this->strSessionKey = new MJaxBSAutocompleteTextBox($this);
        $this->strSessionKey->SetSearchEntity('authsession', 'sessionKey');
        $this->strSessionKey->Name = 'sessionKey';
        $this->strSessionKey->AddCssClass('input-large');
    }
    public function InitIpAddressAutocomplete() {
        $this->strIpAddress = new MJaxBSAutocompleteTextBox($this);
        $this->strIpAddress->SetSearchEntity('authsession', 'ipAddress');
        $this->strIpAddress->Name = 'ipAddress';
        $this->strIpAddress->AddCssClass('input-large');
    }
}
?>