<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthRoll()
* - SetAuthRoll()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitEntityTypeAutocomplete()
* - InitRollTypeAutocomplete()
* - InitDataAutocomplete()
* - InitInviteEmailAutocomplete()
* - InitInviteTokenAutocomplete()
* - InitIdInviteUserAutocomplete()
* Classes list:
* - AuthRollEditPanelBase extends MJaxPanel
*/
class AuthRollEditPanelBase extends MJaxPanel {
    protected $objAuthRoll = null;
    public $intIdAuthRoll = null;
    public $intIdAuthUser = null;
    public $intIdEntity = null;
    public $dttCreDate = null;
    public $strEntityType = null;
    public $strRollType = null;
    public $strData = null;
    public $strInviteEmail = null;
    public $strInviteToken = null;
    public $strIdInviteUser = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthRoll = null) {
        parent::__construct($objParentControl);
        $this->objAuthRoll = $objAuthRoll;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthRollEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthRoll)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->intIdAuthUser = new MJaxTextBox($this);
        $this->intIdAuthUser->Name = 'idAuthUser';
        $this->intIdAuthUser->AddCssClass('input-large');
        //int(11)
        $this->intIdEntity = new MJaxTextBox($this);
        $this->intIdEntity->Name = 'idEntity';
        $this->intIdEntity->AddCssClass('input-large');
        //int(11)
        //Is special field!!!!!
        //Do nothing this is a creDate
        $this->strEntityType = new MJaxTextBox($this);
        $this->strEntityType->Name = 'entityType';
        $this->strEntityType->AddCssClass('input-large');
        //varchar(128)
        $this->strRollType = new MJaxTextBox($this);
        $this->strRollType->Name = 'rollType';
        $this->strRollType->AddCssClass('input-large');
        //varchar(64)
        //Is special field!!!!!
        $this->strInviteEmail = new MJaxTextBox($this);
        $this->strInviteEmail->Name = 'inviteEmail';
        $this->strInviteEmail->AddCssClass('input-large');
        //varchar(256)
        $this->strInviteToken = new MJaxTextBox($this);
        $this->strInviteToken->Name = 'inviteToken';
        $this->strInviteToken->AddCssClass('input-large');
        //varchar(256)
        $this->strIdInviteUser = new MJaxTextBox($this);
        $this->strIdInviteUser->Name = 'idInviteUser';
        $this->strIdInviteUser->AddCssClass('input-large');
        //varchar(45)
        if (!is_null($this->objAuthRoll)) {
            $this->SetAuthRoll($this->objAuthRoll);
        }
    }
    public function GetAuthRoll() {
        if (is_null($this->objAuthRoll)) {
            //Create a new one
            $this->objAuthRoll = new AuthRoll();
        }
        if (get_class($this->intIdAuthUser) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdAuthUser->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idAuthUser');
            }
            $this->objAuthRoll->idAuthUser = $mixEntity;
        } else {
            $this->objAuthRoll->idAuthUser = $this->intIdAuthUser->Text;
        }
        if (get_class($this->intIdEntity) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdEntity->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idEntity');
            }
            $this->objAuthRoll->idEntity = $mixEntity;
        } else {
            $this->objAuthRoll->idEntity = $this->intIdEntity->Text;
        }
        //Is special field!!!!!
        //Do nothing this is a creDate
        if (get_class($this->strEntityType) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strEntityType->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('entityType');
            }
            $this->objAuthRoll->entityType = $mixEntity;
        } else {
            $this->objAuthRoll->entityType = $this->strEntityType->Text;
        }
        if (get_class($this->strRollType) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strRollType->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('rollType');
            }
            $this->objAuthRoll->rollType = $mixEntity;
        } else {
            $this->objAuthRoll->rollType = $this->strRollType->Text;
        }
        //Is special field!!!!!
        if (get_class($this->strInviteEmail) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strInviteEmail->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('inviteEmail');
            }
            $this->objAuthRoll->inviteEmail = $mixEntity;
        } else {
            $this->objAuthRoll->inviteEmail = $this->strInviteEmail->Text;
        }
        if (get_class($this->strInviteToken) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strInviteToken->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('inviteToken');
            }
            $this->objAuthRoll->inviteToken = $mixEntity;
        } else {
            $this->objAuthRoll->inviteToken = $this->strInviteToken->Text;
        }
        if (get_class($this->strIdInviteUser) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strIdInviteUser->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idInviteUser');
            }
            $this->objAuthRoll->idInviteUser = $mixEntity;
        } else {
            $this->objAuthRoll->idInviteUser = $this->strIdInviteUser->Text;
        }
        return $this->objAuthRoll;
    }
    public function SetAuthRoll($objAuthRoll) {
        $this->objAuthRoll = $objAuthRoll;
        $this->ActionParameter = $this->objAuthRoll;
        $this->blnModified = true;
        if (!is_null($this->objAuthRoll)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdAuthRoll = $this->objAuthRoll->idAuthRoll;
            $this->intIdAuthUser->Text = $this->objAuthRoll->idAuthUser;
            $this->intIdEntity->Text = $this->objAuthRoll->idEntity;
            //Is special field!!!!!
            //Do nothing this is a creDate
            $this->strEntityType->Text = $this->objAuthRoll->entityType;
            $this->strRollType->Text = $this->objAuthRoll->rollType;
            //Is special field!!!!!
            $this->strInviteEmail->Text = $this->objAuthRoll->inviteEmail;
            $this->strInviteToken->Text = $this->objAuthRoll->inviteToken;
            $this->strIdInviteUser->Text = $this->objAuthRoll->idInviteUser;
        } else {
            $this->intIdAuthUser->Text = '';
            $this->intIdEntity->Text = '';
            //Is special field!!!!!
            //Do nothing this is a creDate
            $this->strEntityType->Text = '';
            $this->strRollType->Text = '';
            //Is special field!!!!!
            $this->strInviteEmail->Text = '';
            $this->strInviteToken->Text = '';
            $this->strIdInviteUser->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthRoll)) {
        }
    }
    public function btnSave_click() {
        $this->GetAuthRoll()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthRoll;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthRoll->MarkDeleted();
        $this->SetAuthRoll(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthRoll);
    }
    public function InitEntityTypeAutocomplete() {
        $this->strEntityType = new MJaxBSAutocompleteTextBox($this);
        $this->strEntityType->SetSearchEntity('authroll', 'entityType');
        $this->strEntityType->Name = 'entityType';
        $this->strEntityType->AddCssClass('input-large');
    }
    public function InitRollTypeAutocomplete() {
        $this->strRollType = new MJaxBSAutocompleteTextBox($this);
        $this->strRollType->SetSearchEntity('authroll', 'rollType');
        $this->strRollType->Name = 'rollType';
        $this->strRollType->AddCssClass('input-large');
    }
    public function InitDataAutocomplete() {
        $this->strData = new MJaxBSAutocompleteTextBox($this);
        $this->strData->SetSearchEntity('authroll', 'data');
        $this->strData->Name = 'data';
        $this->strData->AddCssClass('input-large');
    }
    public function InitInviteEmailAutocomplete() {
        $this->strInviteEmail = new MJaxBSAutocompleteTextBox($this);
        $this->strInviteEmail->SetSearchEntity('authroll', 'inviteEmail');
        $this->strInviteEmail->Name = 'inviteEmail';
        $this->strInviteEmail->AddCssClass('input-large');
    }
    public function InitInviteTokenAutocomplete() {
        $this->strInviteToken = new MJaxBSAutocompleteTextBox($this);
        $this->strInviteToken->SetSearchEntity('authroll', 'inviteToken');
        $this->strInviteToken->Name = 'inviteToken';
        $this->strInviteToken->AddCssClass('input-large');
    }
    public function InitIdInviteUserAutocomplete() {
        $this->strIdInviteUser = new MJaxBSAutocompleteTextBox($this);
        $this->strIdInviteUser->SetSearchEntity('authroll', 'idInviteUser');
        $this->strIdInviteUser->Name = 'idInviteUser';
        $this->strIdInviteUser->AddCssClass('input-large');
    }
}
?>