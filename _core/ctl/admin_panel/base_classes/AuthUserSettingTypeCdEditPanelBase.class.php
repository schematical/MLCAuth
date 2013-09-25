<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthUserSettingTypeCd()
* - SetAuthUserSettingTypeCd()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitShortDescAutocomplete()
* Classes list:
* - AuthUserSettingTypeCdEditPanelBase extends MJaxPanel
*/
class AuthUserSettingTypeCdEditPanelBase extends MJaxPanel {
    protected $objAuthUserSettingTypeCd = null;
    public $intIdUserSettingType = null;
    public $strShortDesc = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthUserSettingTypeCd = null) {
        parent::__construct($objParentControl);
        $this->objAuthUserSettingTypeCd = $objAuthUserSettingTypeCd;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthUserSettingTypeCdEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthUserSettingTypeCd)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
        //varchar(16)
        if (!is_null($this->objAuthUserSettingTypeCd)) {
            $this->SetAuthUserSettingTypeCd($this->objAuthUserSettingTypeCd);
        }
    }
    public function GetAuthUserSettingTypeCd() {
        if (is_null($this->objAuthUserSettingTypeCd)) {
            //Create a new one
            $this->objAuthUserSettingTypeCd = new AuthUserSettingTypeCd();
        }
        if (get_class($this->strShortDesc) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strShortDesc->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('shortDesc');
            }
            $this->objAuthUserSettingTypeCd->shortDesc = $mixEntity;
        } else {
            $this->objAuthUserSettingTypeCd->shortDesc = $this->strShortDesc->Text;
        }
        return $this->objAuthUserSettingTypeCd;
    }
    public function SetAuthUserSettingTypeCd($objAuthUserSettingTypeCd) {
        $this->objAuthUserSettingTypeCd = $objAuthUserSettingTypeCd;
        $this->ActionParameter = $this->objAuthUserSettingTypeCd;
        $this->blnModified = true;
        if (!is_null($this->objAuthUserSettingTypeCd)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdUserSettingType = $this->objAuthUserSettingTypeCd->idUserSettingType;
            $this->strShortDesc->Text = $this->objAuthUserSettingTypeCd->shortDesc;
        } else {
            $this->strShortDesc->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthUserSettingTypeCd)) {
        }
    }
    public function btnSave_click() {
        $this->GetAuthUserSettingTypeCd()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthUserSettingTypeCd;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthUserSettingTypeCd->MarkDeleted();
        $this->SetAuthUserSettingTypeCd(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthUserSettingTypeCd);
    }
    public function InitShortDescAutocomplete() {
        $this->strShortDesc = new MJaxBSAutocompleteTextBox($this);
        $this->strShortDesc->SetSearchEntity('authusersettingtypecd', 'shortDesc');
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
    }
}
?>