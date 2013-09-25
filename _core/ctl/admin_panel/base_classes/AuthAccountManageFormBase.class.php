<?php
/**
* Class and Function List:
* Function list:
* - Form_Create()
* - Query()
* - InitSelectPanel()
* - pnlSelect_change()
* - InitEditPanel()
* - pnlEdit_save()
* - pnlEdit_delete()
* - InitList()
* - lstAuthAccount_editInit()
* - lstAuthAccount_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthAccountManageFormBase extends FFSForm
*/
class AuthAccountManageFormBase extends FFSForm {
    public $lstAuthAccounts = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdAccount = MLCApplication::QS(FFSQS::AuthAccount_IdAccount);
        if (!is_null($intIdAccount)) {
            $arrAndConditions[] = sprintf('AuthAccount.idAccount = %s', $intIdAccount);
        }
        $strShortDesc = MLCApplication::QS(FFSQS::AuthAccount_ShortDesc);
        if (!is_null($strShortDesc)) {
            $arrAndConditions[] = sprintf('AuthAccount.shortDesc LIKE "%s%%"', $strShortDesc);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthAccounts = AuthAccount::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthAccounts = array();
        }
        return $arrAuthAccounts;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthAccountSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthAccount = $this->AddWidget('Select AuthAccount', 'icon-select', $this->pnlSelect);
        $wgtAuthAccount->AddCssClass('span6');
        return $wgtAuthAccount;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthAccounts = $this->pnlSelect->GetValue();
        if (count($arrAuthAccounts) == 1) {
            $this->pnlEdit->SetAuthAccount($arrAuthAccounts[0]);
            foreach ($this->lstAuthAccounts as $objRow) {
                if ($objRow->ActionParameter == $arrAuthAccounts[0]->IdAccount) {
                    $this->lstAuthAccounts->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthAccounts);
        //}
        $this->lstAuthAccounts->RemoveAllChildControls();
        $this->lstAuthAccounts->SetDataEntites($arrAuthAccounts);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthAccount = null) {
        $this->pnlEdit = new AuthAccountEditPanel($this, $objAuthAccount);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthAccount = $this->AddWidget(((is_null($objAuthAccount)) ? 'Create AuthAccount' : 'Edit AuthAccount') , 'icon-edit', $this->pnlEdit);
        $wgtAuthAccount->AddCssClass('span6');
        return $wgtAuthAccount;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthAccount) {
        $pnlRow = $this->UpdateTable($objAuthAccount);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthAccount(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthAccount) {
        $this->lstAuthAccounts->SelectedRow->Remove();
        $this->lstAuthAccounts->SelectedRow = null;
    }
    public function InitList($arrAuthAccounts) {
        $this->lstAuthAccounts = new AuthAccountListPanel($this, $arrAuthAccounts);
        $this->lstAuthAccounts->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthAccount_editInit'));
        $this->lstAuthAccounts->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthAccount_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthAccounts->InitRemoveButtons();
            $this->lstAuthAccounts->InitEditControls();
            $this->lstAuthAccounts->AddEmptyRow();
        } else {
            $this->lstAuthAccounts->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthAccount = $this->AddWidget('AuthAccounts', 'icon-ul', $this->lstAuthAccounts);
        $wgtAuthAccount->AddCssClass('span12');
        return $wgtAuthAccount;
    }
    public function lstAuthAccount_editInit() {
        //_dv($this->lstAuthAccounts->SelectedRow);
        
    }
    public function lstAuthAccount_editSave() {
        $objAuthAccount = AuthAccount::LoadById($this->lstAuthAccounts->SelectedRow->ActionParameter);
        if (is_null($objAuthAccount)) {
            $objAuthAccount = new AuthAccount();
        }
        $objAuthAccount->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthAccounts->SelectedRow->UpdateEntity($objAuthAccount);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthAccount(AuthAccount::LoadById($strActionParameter));
        $this->lstAuthAccounts->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthAccount) {
        //_dv($objAuthAccount);
        if (!is_null($this->lstAuthAccounts->SelectedRow)) {
            //This already exists
            $this->lstAuthAccounts->SelectedRow->UpdateEntity($objAuthAccount);
            $objRow = $this->lstAuthAccounts->SelectedRow;
            $this->lstAuthAccounts->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthAccounts->AddRow($objAuthAccount);
        }
        $this->lstAuthAccounts->RefreshControls();
        return $objRow;
    }
}
