<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthUser()
* - SetAuthUser()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitEmailAutocomplete()
* - InitPasswordAutocomplete()
* - InitUsernameAutocomplete()
* - InitPassResetCodeAutocomplete()
* - InitFbuidAutocomplete()
* - InitFbAccessTokenAutocomplete()
* Classes list:
* - AuthUserEditPanelBase extends MJaxPanel
*/
class AuthUserEditPanelBase extends MJaxPanel {
    protected $objAuthUser = null;
    public $intIdUser = null;
    public $strEmail = null;
    public $strPassword = null;
    public $intIdAccount = null;
    public $intIdUserTypeCd = null;
    public $strUsername = null;
    public $strPassResetCode = null;
    public $strFbuid = null;
    public $strFbAccessToken = null;
    public $intActive = null;
    public $strFriendsIds = null;
    public $dttFriendsUpdated = null;
    public $intFbAccessTokenExpires = null;
    public $lnkViewChildAuthSession = null;
    public $lnkViewChildAuthUserSetting = null;
    public $lnkViewChildMLCNotification = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthUser = null) {
        parent::__construct($objParentControl);
        $this->objAuthUser = $objAuthUser;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthUserEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthUser)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->strEmail = new MJaxTextBox($this);
        $this->strEmail->Name = 'email';
        $this->strEmail->AddCssClass('input-large');
        //varchar(64)
        $this->strPassword = new MJaxTextBox($this);
        $this->strPassword->Name = 'password';
        $this->strPassword->AddCssClass('input-large');
        //varchar(64)
        $this->intIdAccount = new MJaxTextBox($this);
        $this->intIdAccount->Name = 'idAccount';
        $this->intIdAccount->AddCssClass('input-large');
        //int(11)
        $this->intIdUserTypeCd = new MJaxTextBox($this);
        $this->intIdUserTypeCd->Name = 'idUserTypeCd';
        $this->intIdUserTypeCd->AddCssClass('input-large');
        //int(11)
        $this->strUsername = new MJaxTextBox($this);
        $this->strUsername->Name = 'username';
        $this->strUsername->AddCssClass('input-large');
        //varchar(128)
        $this->strPassResetCode = new MJaxTextBox($this);
        $this->strPassResetCode->Name = 'passResetCode';
        $this->strPassResetCode->AddCssClass('input-large');
        //varchar(128)
        $this->strFbuid = new MJaxTextBox($this);
        $this->strFbuid->Name = 'fbuid';
        $this->strFbuid->AddCssClass('input-large');
        //varchar(128)
        $this->strFbAccessToken = new MJaxTextBox($this);
        $this->strFbAccessToken->Name = 'fbAccessToken';
        $this->strFbAccessToken->AddCssClass('input-large');
        //varchar(256)
        $this->intActive = new MJaxTextBox($this);
        $this->intActive->Name = 'active';
        $this->intActive->AddCssClass('input-large');
        //int(1)
        $this->strFriendsIds = new MJaxTextBox($this);
        $this->strFriendsIds->Name = 'friendsIds';
        $this->strFriendsIds->AddCssClass('input-large');
        //longtext
        $this->strFriendsIds->TextMode = MJaxTextMode::MultiLine;
        $this->dttFriendsUpdated = new MJaxTextBox($this);
        $this->dttFriendsUpdated->Name = 'friendsUpdated';
        $this->dttFriendsUpdated->AddCssClass('input-large');
        //datetime
        $this->intFbAccessTokenExpires = new MJaxTextBox($this);
        $this->intFbAccessTokenExpires->Name = 'fbAccessTokenExpires';
        $this->intFbAccessTokenExpires->AddCssClass('input-large');
        //int(11)
        if (!is_null($this->objAuthUser)) {
            $this->SetAuthUser($this->objAuthUser);
        }
    }
    public function GetAuthUser() {
        if (is_null($this->objAuthUser)) {
            //Create a new one
            $this->objAuthUser = new AuthUser();
        }
        if (get_class($this->strEmail) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strEmail->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('email');
            }
            $this->objAuthUser->email = $mixEntity;
        } else {
            $this->objAuthUser->email = $this->strEmail->Text;
        }
        if (get_class($this->strPassword) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strPassword->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('password');
            }
            $this->objAuthUser->password = $mixEntity;
        } else {
            $this->objAuthUser->password = $this->strPassword->Text;
        }
        if (get_class($this->intIdAccount) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdAccount->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idAccount');
            }
            $this->objAuthUser->idAccount = $mixEntity;
        } else {
            $this->objAuthUser->idAccount = $this->intIdAccount->Text;
        }
        if (get_class($this->intIdUserTypeCd) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdUserTypeCd->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idUserTypeCd');
            }
            $this->objAuthUser->idUserTypeCd = $mixEntity;
        } else {
            $this->objAuthUser->idUserTypeCd = $this->intIdUserTypeCd->Text;
        }
        if (get_class($this->strUsername) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strUsername->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('username');
            }
            $this->objAuthUser->username = $mixEntity;
        } else {
            $this->objAuthUser->username = $this->strUsername->Text;
        }
        if (get_class($this->strPassResetCode) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strPassResetCode->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('passResetCode');
            }
            $this->objAuthUser->passResetCode = $mixEntity;
        } else {
            $this->objAuthUser->passResetCode = $this->strPassResetCode->Text;
        }
        if (get_class($this->strFbuid) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strFbuid->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('fbuid');
            }
            $this->objAuthUser->fbuid = $mixEntity;
        } else {
            $this->objAuthUser->fbuid = $this->strFbuid->Text;
        }
        if (get_class($this->strFbAccessToken) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strFbAccessToken->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('fbAccessToken');
            }
            $this->objAuthUser->fbAccessToken = $mixEntity;
        } else {
            $this->objAuthUser->fbAccessToken = $this->strFbAccessToken->Text;
        }
        if (get_class($this->intActive) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intActive->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('active');
            }
            $this->objAuthUser->active = $mixEntity;
        } else {
            $this->objAuthUser->active = $this->intActive->Text;
        }
        if (get_class($this->strFriendsIds) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strFriendsIds->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('friendsIds');
            }
            $this->objAuthUser->friendsIds = $mixEntity;
        } else {
            $this->objAuthUser->friendsIds = $this->strFriendsIds->Text;
        }
        if (get_class($this->dttFriendsUpdated) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->dttFriendsUpdated->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('friendsUpdated');
            }
            $this->objAuthUser->friendsUpdated = $mixEntity;
        } else {
            $this->objAuthUser->friendsUpdated = $this->dttFriendsUpdated->Text;
        }
        if (get_class($this->intFbAccessTokenExpires) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intFbAccessTokenExpires->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('fbAccessTokenExpires');
            }
            $this->objAuthUser->fbAccessTokenExpires = $mixEntity;
        } else {
            $this->objAuthUser->fbAccessTokenExpires = $this->intFbAccessTokenExpires->Text;
        }
        return $this->objAuthUser;
    }
    public function SetAuthUser($objAuthUser) {
        $this->objAuthUser = $objAuthUser;
        $this->ActionParameter = $this->objAuthUser;
        $this->blnModified = true;
        if (!is_null($this->objAuthUser)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdUser = $this->objAuthUser->idUser;
            $this->strEmail->Text = $this->objAuthUser->email;
            $this->strPassword->Text = $this->objAuthUser->password;
            $this->intIdAccount->Text = $this->objAuthUser->idAccount;
            $this->intIdUserTypeCd->Text = $this->objAuthUser->idUserTypeCd;
            $this->strUsername->Text = $this->objAuthUser->username;
            $this->strPassResetCode->Text = $this->objAuthUser->passResetCode;
            $this->strFbuid->Text = $this->objAuthUser->fbuid;
            $this->strFbAccessToken->Text = $this->objAuthUser->fbAccessToken;
            $this->intActive->Text = $this->objAuthUser->active;
            $this->strFriendsIds->Text = $this->objAuthUser->friendsIds;
            $this->dttFriendsUpdated->Text = $this->objAuthUser->friendsUpdated;
            $this->intFbAccessTokenExpires->Text = $this->objAuthUser->fbAccessTokenExpires;
        } else {
            $this->strEmail->Text = '';
            $this->strPassword->Text = '';
            $this->intIdAccount->Text = '';
            $this->intIdUserTypeCd->Text = '';
            $this->strUsername->Text = '';
            $this->strPassResetCode->Text = '';
            $this->strFbuid->Text = '';
            $this->strFbAccessToken->Text = '';
            $this->intActive->Text = '';
            $this->strFriendsIds->Text = '';
            $this->dttFriendsUpdated->Text = '';
            $this->intFbAccessTokenExpires->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthUser)) {
        }
        $this->lnkViewChildAuthSession = new MJaxLinkButton($this);
        $this->lnkViewChildAuthSession->Text = 'View AuthSessions';
        //I should really fix this
        //$this->lnkViewChildAuthSession->Href = __ENTITY_MODEL_DIR__ . '/AuthUser/' . $this->objAuthUser->idUser . '/AuthSessions';
        $this->lnkViewChildAuthUserSetting = new MJaxLinkButton($this);
        $this->lnkViewChildAuthUserSetting->Text = 'View AuthUserSettings';
        //I should really fix this
        //$this->lnkViewChildAuthUserSetting->Href = __ENTITY_MODEL_DIR__ . '/AuthUser/' . $this->objAuthUser->idUser . '/AuthUserSettings';
        $this->lnkViewChildMLCNotification = new MJaxLinkButton($this);
        $this->lnkViewChildMLCNotification->Text = 'View MLCNotifications';
        //I should really fix this
        //$this->lnkViewChildMLCNotification->Href = __ENTITY_MODEL_DIR__ . '/AuthUser/' . $this->objAuthUser->idUser . '/MLCNotifications';
        
    }
    public function btnSave_click() {
        $this->GetAuthUser()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthUser;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthUser->MarkDeleted();
        $this->SetAuthUser(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthUser);
    }
    public function InitEmailAutocomplete() {
        $this->strEmail = new MJaxBSAutocompleteTextBox($this);
        $this->strEmail->SetSearchEntity('authuser', 'email');
        $this->strEmail->Name = 'email';
        $this->strEmail->AddCssClass('input-large');
    }
    public function InitPasswordAutocomplete() {
        $this->strPassword = new MJaxBSAutocompleteTextBox($this);
        $this->strPassword->SetSearchEntity('authuser', 'password');
        $this->strPassword->Name = 'password';
        $this->strPassword->AddCssClass('input-large');
    }
    public function InitUsernameAutocomplete() {
        $this->strUsername = new MJaxBSAutocompleteTextBox($this);
        $this->strUsername->SetSearchEntity('authuser', 'username');
        $this->strUsername->Name = 'username';
        $this->strUsername->AddCssClass('input-large');
    }
    public function InitPassResetCodeAutocomplete() {
        $this->strPassResetCode = new MJaxBSAutocompleteTextBox($this);
        $this->strPassResetCode->SetSearchEntity('authuser', 'passResetCode');
        $this->strPassResetCode->Name = 'passResetCode';
        $this->strPassResetCode->AddCssClass('input-large');
    }
    public function InitFbuidAutocomplete() {
        $this->strFbuid = new MJaxBSAutocompleteTextBox($this);
        $this->strFbuid->SetSearchEntity('authuser', 'fbuid');
        $this->strFbuid->Name = 'fbuid';
        $this->strFbuid->AddCssClass('input-large');
    }
    public function InitFbAccessTokenAutocomplete() {
        $this->strFbAccessToken = new MJaxBSAutocompleteTextBox($this);
        $this->strFbAccessToken->SetSearchEntity('authuser', 'fbAccessToken');
        $this->strFbAccessToken->Name = 'fbAccessToken';
        $this->strFbAccessToken->AddCssClass('input-large');
    }
}
?>