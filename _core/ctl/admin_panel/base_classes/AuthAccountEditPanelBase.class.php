<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - GetAuthAccount()
* - SetAuthAccount()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - btnDelete_confirm()
* - IsNew()
* - InitShortDescAutocomplete()
* Classes list:
* - AuthAccountEditPanelBase extends MJaxPanel
*/
class AuthAccountEditPanelBase extends MJaxPanel {
    protected $objAuthAccount = null;
    public $intIdAccount = null;
    public $intIdAccountTypeCd = null;
    public $intIdUser = null;
    public $dttCreDate = null;
    public $strShortDesc = null;
    public $lnkViewChildMLCLocation = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $objAuthAccount = null) {
        parent::__construct($objParentControl);
        $this->objAuthAccount = $objAuthAccount;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/AuthAccountEditPanelBase.tpl.php';
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
        if (is_null($this->objAuthAccount)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        $this->intIdAccountTypeCd = new MJaxTextBox($this);
        $this->intIdAccountTypeCd->Name = 'idAccountTypeCd';
        $this->intIdAccountTypeCd->AddCssClass('input-large');
        //int(11)
        //Is special field!!!!!
        //Is special field!!!!!
        //Do nothing this is a creDate
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
        //varchar(45)
        if (!is_null($this->objAuthAccount)) {
            $this->SetAuthAccount($this->objAuthAccount);
        }
    }
    public function GetAuthAccount() {
        if (is_null($this->objAuthAccount)) {
            //Create a new one
            $this->objAuthAccount = new AuthAccount();
        }
        if (get_class($this->intIdAccountTypeCd) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->intIdAccountTypeCd->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('idAccountTypeCd');
            }
            $this->objAuthAccount->idAccountTypeCd = $mixEntity;
        } else {
            $this->objAuthAccount->idAccountTypeCd = $this->intIdAccountTypeCd->Text;
        }
        //Is special field!!!!!
        $this->objAuthAccount->idUser = MLCAuthDriver::IdUser();
        //Is special field!!!!!
        //Do nothing this is a creDate
        if (get_class($this->strShortDesc) == 'MJaxBSAutocompleteTextBox') {
            $mixEntity = $this->strShortDesc->GetValue();
            if (is_object($mixEntity)) {
                $mixEntity = $mixEntity->__get('shortDesc');
            }
            $this->objAuthAccount->shortDesc = $mixEntity;
        } else {
            $this->objAuthAccount->shortDesc = $this->strShortDesc->Text;
        }
        return $this->objAuthAccount;
    }
    public function SetAuthAccount($objAuthAccount) {
        $this->objAuthAccount = $objAuthAccount;
        $this->ActionParameter = $this->objAuthAccount;
        $this->blnModified = true;
        if (!is_null($this->objAuthAccount)) {
            if (!is_null($this->btnDelete)) {
                $this->btnDelete->Style->Display = 'inline';
            }
            //PKey
            $this->intIdAccount = $this->objAuthAccount->idAccount;
            $this->intIdAccountTypeCd->Text = $this->objAuthAccount->idAccountTypeCd;
            //Is special field!!!!!
            //Is special field!!!!!
            //Do nothing this is a creDate
            $this->strShortDesc->Text = $this->objAuthAccount->shortDesc;
        } else {
            $this->intIdAccountTypeCd->Text = '';
            //Is special field!!!!!
            //Is special field!!!!!
            //Do nothing this is a creDate
            $this->strShortDesc->Text = '';
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateReferenceControls() {
        if (!is_null($this->objAuthAccount)) {
        }
        $this->lnkViewChildMLCLocation = new MJaxLinkButton($this);
        $this->lnkViewChildMLCLocation->Text = 'View MLCLocations';
        //I should really fix this
        //$this->lnkViewChildMLCLocation->Href = __ENTITY_MODEL_DIR__ . '/AuthAccount/' . $this->objAuthAccount->idAccount . '/MLCLocations';
        
    }
    public function btnSave_click() {
        $this->GetAuthAccount()->Save();
        //Experimental save event trigger
        $this->ActionParameter = $this->objAuthAccount;
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-save');
    }
    public function btnDelete_click() {
        $this->Confirm('Are you sure you want to delete this?', 'btnDelete_confirm');
    }
    public function btnDelete_confirm() {
        $this->objAuthAccount->MarkDeleted();
        $this->SetAuthAccount(null);
        //Experimental delete event trigger
        $this->objForm->TriggerControlEvent($this->strControlId, 'mjax-data-entity-delete');
    }
    public function IsNew() {
        return is_null($this->objAuthAccount);
    }
    public function InitShortDescAutocomplete() {
        $this->strShortDesc = new MJaxBSAutocompleteTextBox($this);
        $this->strShortDesc->SetSearchEntity('authaccount', 'shortDesc');
        $this->strShortDesc->Name = 'shortDesc';
        $this->strShortDesc->AddCssClass('input-large');
    }
}
?>