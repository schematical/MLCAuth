<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthUserSetting()
* - SetAuthUserSetting()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitIdUserAutocomplete()
* - InitNamespaceAutocomplete()
* Classes list:
* - AuthUserSettingEditPanelBase extends MJaxPanel
*/
class AuthUserSettingEditPanelBase extends MJaxPanel {
    protected $objAuthUserSetting = null;
    public $intIdUserSetting = null;
    public $intIdUser = null;
    public $intIdUserSettingTypeCd = null;
    public $strData = null;
    public $strNamespace = null;
    public $lnkViewParentIdUser = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthUserSetting = null) {
        parent::__construct($objParentControl);
        $this->objAuthUserSetting = $objAuthUserSetting;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthUserSettingEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthUserSetting)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        //Is special field!!!!!
        $this->intIdUserSettingTypeCd = new MJaxTextBox($this);
        $this->intIdUserSettingTypeCd->Name = 'idUserSettingTypeCd';
        $this->intIdUserSettingTypeCd->AddCssClass('input-large');
        //int(11)
        //Is special field!!!!!
        $this->strNamespace = new MJaxTextBox($this);
        $this->strNamespace->Name = 'namespace';
        $this->strNamespace->AddCssClass('input-large');
        //varchar(64)
        if (!is_null($this->objAuthUserSetting)) {
            $this->SetAuthUserSetting($this->objAuthUserSetting);
        }
    }
    public function GetAuthUserSetting() {
        if (is_null($this->objAuthUserSetting)) {
            //Create a new one
            $this->objAuthUserSetting = new AuthUserSetting();
        }
        //Is special field!!!!!
        $this->objAuthUserSetting->idUser = MLCAuthDriver::IdUser();
        if (get_class($this->intIdUserSettingTypeCd) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdUserSettingTypeCd->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idUserSettingTypeCd');
            }
            $this->objAuthUserSetting->idUserSettingTypeCd = $mixEntity;
        } else {
            $this->objAuthUserSetting->idUserSettingTypeCd = $this->intIdUserSettingTypeCd->Text;
        }
        //Is special field!!!!!
        if (get_class($this->strNamespace) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strNamespace->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('namespace');
            }
            $this->objAuthUserSetting->namespace = $mixEntity;
        } else {
            $this->objAuthUserSetting->namespace = $this->strNamespace->Text;
        }
        return $this->objAuthUserSetting;
    }
    public function SetAuthUserSetting($objAuthUserSetting) {
        $this->objAuthUserSetting = $objAuthUserSetting;
        $this->ActionParameter = $this->objAuthUserSetting;
        $this->blnModified = true;
        if (!is_null($this->objAuthUserSetting)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdUserSetting = $this->objAuthUserSetting->idUserSetting;
            //Is special field!!!!!
            $this->intIdUserSettingTypeCd->Text = $this->objAuthUserSetting->idUserSettingTypeCd;
            //Is special field!!!!!
            $this->strNamespace->Text = $this->objAuthUserSetting->namespace;
        } else {
            //Is special field!!!!!
            $this->intIdUserSettingTypeCd->Text = '';
            //Is special field!!!!!
            $this->strNamespace->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthUserSetting)) {
            if (!is_null($this->objAuthUserSetting->idUser)) {
                $this->lnkViewParentIdUser = new MJaxLinkButton($this);
                $this->lnkViewParentIdUser->Text = 'View AuthUser';
                $this->lnkViewParentIdUser->Href = '/data/editAuthUserSetting?' . FFSQS::AuthUserSetting_IdUser . $this->objAuthUserSetting->idUser;
            }
        }
    }
    public function btnSave_click() {
        $this->GetAuthUserSetting()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthUserSetting;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthUserSetting->MarkDeleted();
        $this->SetAuthUserSetting(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthUserSetting);
    }
    public function InitIdUserAutocomplete() {
        $this->intIdUser = new MJaxBSAutocompleteTextBox($this);
        $this->intIdUser->SetSearchEntity('authuser');
        $this->intIdUser->Name = 'idUser';
        $this->intIdUser->AddCssClass('input-large');
    }
    public function InitNamespaceAutocomplete() {
        $this->strNamespace = new MJaxBSAutocompleteTextBox($this);
        $this->strNamespace->SetSearchEntity('authusersetting', 'namespace');
        $this->strNamespace->Name = 'namespace';
        $this->strNamespace->AddCssClass('input-large');
    }
}
?>