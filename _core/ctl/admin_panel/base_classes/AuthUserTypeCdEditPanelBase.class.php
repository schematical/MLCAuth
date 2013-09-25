<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthUserTypeCd()
* - SetAuthUserTypeCd()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitShortDescAutocomplete()
* Classes list:
* - AuthUserTypeCdEditPanelBase extends MJaxPanel
*/
class AuthUserTypeCdEditPanelBase extends MJaxPanel {
    protected $objAuthUserTypeCd = null;
    public $intIdUserTypeCd = null;
    public $strShortDesc = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthUserTypeCd = null) {
        parent::__construct($objParentControl);
        $this->objAuthUserTypeCd = $objAuthUserTypeCd;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthUserTypeCdEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthUserTypeCd)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
        //varchar(128)
        if (!is_null($this->objAuthUserTypeCd)) {
            $this->SetAuthUserTypeCd($this->objAuthUserTypeCd);
        }
    }
    public function GetAuthUserTypeCd() {
        if (is_null($this->objAuthUserTypeCd)) {
            //Create a new one
            $this->objAuthUserTypeCd = new AuthUserTypeCd();
        }
        if (get_class($this->strShortDesc) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strShortDesc->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('shortDesc');
            }
            $this->objAuthUserTypeCd->shortDesc = $mixEntity;
        } else {
            $this->objAuthUserTypeCd->shortDesc = $this->strShortDesc->Text;
        }
        return $this->objAuthUserTypeCd;
    }
    public function SetAuthUserTypeCd($objAuthUserTypeCd) {
        $this->objAuthUserTypeCd = $objAuthUserTypeCd;
        $this->ActionParameter = $this->objAuthUserTypeCd;
        $this->blnModified = true;
        if (!is_null($this->objAuthUserTypeCd)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdUserTypeCd = $this->objAuthUserTypeCd->idUserTypeCd;
            $this->strShortDesc->Text = $this->objAuthUserTypeCd->shortDesc;
        } else {
            $this->strShortDesc->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthUserTypeCd)) {
        }
    }
    public function btnSave_click() {
        $this->GetAuthUserTypeCd()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthUserTypeCd;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthUserTypeCd->MarkDeleted();
        $this->SetAuthUserTypeCd(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthUserTypeCd);
    }
    public function InitShortDescAutocomplete() {
        $this->strShortDesc = new MJaxBSAutocompleteTextBox($this);
        $this->strShortDesc->SetSearchEntity('authusertypecd', 'shortDesc');
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
    }
}
?>