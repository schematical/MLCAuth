<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthAccountTypeCd()
* - SetAuthAccountTypeCd()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitShortDescAutocomplete()
* Classes list:
* - AuthAccountTypeCdEditPanelBase extends MJaxPanel
*/
class AuthAccountTypeCdEditPanelBase extends MJaxPanel {
    protected $objAuthAccountTypeCd = null;
    public $intIdAccountTypeCd = null;
    public $strShortDesc = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthAccountTypeCd = null) {
        parent::__construct($objParentControl);
        $this->objAuthAccountTypeCd = $objAuthAccountTypeCd;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthAccountTypeCdEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthAccountTypeCd)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
        //varchar(64)
        if (!is_null($this->objAuthAccountTypeCd)) {
            $this->SetAuthAccountTypeCd($this->objAuthAccountTypeCd);
        }
    }
    public function GetAuthAccountTypeCd() {
        if (is_null($this->objAuthAccountTypeCd)) {
            //Create a new one
            $this->objAuthAccountTypeCd = new AuthAccountTypeCd();
        }
        if (get_class($this->strShortDesc) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strShortDesc->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('shortDesc');
            }
            $this->objAuthAccountTypeCd->shortDesc = $mixEntity;
        } else {
            $this->objAuthAccountTypeCd->shortDesc = $this->strShortDesc->Text;
        }
        return $this->objAuthAccountTypeCd;
    }
    public function SetAuthAccountTypeCd($objAuthAccountTypeCd) {
        $this->objAuthAccountTypeCd = $objAuthAccountTypeCd;
        $this->ActionParameter = $this->objAuthAccountTypeCd;
        $this->blnModified = true;
        if (!is_null($this->objAuthAccountTypeCd)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdAccountTypeCd = $this->objAuthAccountTypeCd->idAccountTypeCd;
            $this->strShortDesc->Text = $this->objAuthAccountTypeCd->shortDesc;
        } else {
            $this->strShortDesc->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthAccountTypeCd)) {
        }
    }
    public function btnSave_click() {
        $this->GetAuthAccountTypeCd()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthAccountTypeCd;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthAccountTypeCd->MarkDeleted();
        $this->SetAuthAccountTypeCd(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthAccountTypeCd);
    }
    public function InitShortDescAutocomplete() {
        $this->strShortDesc = new MJaxBSAutocompleteTextBox($this);
        $this->strShortDesc->SetSearchEntity('authaccounttypecd', 'shortDesc');
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
    }
}
?>