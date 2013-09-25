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
* - lstAuthAccountTypeCd_editInit()
* - lstAuthAccountTypeCd_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthAccountTypeCdManageFormBase extends FFSForm
*/
class AuthAccountTypeCdManageFormBase extends FFSForm {
    public $lstAuthAccountTypeCds = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdAccountTypeCd = MLCApplication::QS(FFSQS::AuthAccountTypeCd_IdAccountTypeCd);
        if (!is_null($intIdAccountTypeCd)) {
            $arrAndConditions[] = sprintf('AuthAccountTypeCd_tpcd.idAccountTypeCd = %s', $intIdAccountTypeCd);
        }
        $strShortDesc = MLCApplication::QS(FFSQS::AuthAccountTypeCd_ShortDesc);
        if (!is_null($strShortDesc)) {
            $arrAndConditions[] = sprintf('AuthAccountTypeCd_tpcd.shortDesc LIKE "%s%%"', $strShortDesc);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthAccountTypeCds = AuthAccountTypeCd::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthAccountTypeCds = array();
        }
        return $arrAuthAccountTypeCds;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthAccountTypeCdSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthAccountTypeCd = $this->AddWidget('Select AuthAccountTypeCd', 'icon-select', $this->pnlSelect);
        $wgtAuthAccountTypeCd->AddCssClass('span6');
        return $wgtAuthAccountTypeCd;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthAccountTypeCds = $this->pnlSelect->GetValue();
        if (count($arrAuthAccountTypeCds) == 1) {
            $this->pnlEdit->SetAuthAccountTypeCd($arrAuthAccountTypeCds[0]);
            foreach ($this->lstAuthAccountTypeCds as $objRow) {
                if ($objRow->ActionParameter == $arrAuthAccountTypeCds[0]->IdAccountTypeCd) {
                    $this->lstAuthAccountTypeCds->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthAccountTypeCds);
        //}
        $this->lstAuthAccountTypeCds->RemoveAllChildControls();
        $this->lstAuthAccountTypeCds->SetDataEntites($arrAuthAccountTypeCds);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthAccountTypeCd = null) {
        $this->pnlEdit = new AuthAccountTypeCdEditPanel($this, $objAuthAccountTypeCd);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthAccountTypeCd = $this->AddWidget(((is_null($objAuthAccountTypeCd)) ? 'Create AuthAccountTypeCd' : 'Edit AuthAccountTypeCd') , 'icon-edit', $this->pnlEdit);
        $wgtAuthAccountTypeCd->AddCssClass('span6');
        return $wgtAuthAccountTypeCd;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthAccountTypeCd) {
        $pnlRow = $this->UpdateTable($objAuthAccountTypeCd);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthAccountTypeCd(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthAccountTypeCd) {
        $this->lstAuthAccountTypeCds->SelectedRow->Remove();
        $this->lstAuthAccountTypeCds->SelectedRow = null;
    }
    public function InitList($arrAuthAccountTypeCds) {
        $this->lstAuthAccountTypeCds = new AuthAccountTypeCdListPanel($this, $arrAuthAccountTypeCds);
        $this->lstAuthAccountTypeCds->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthAccountTypeCd_editInit'));
        $this->lstAuthAccountTypeCds->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthAccountTypeCd_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthAccountTypeCds->InitRemoveButtons();
            $this->lstAuthAccountTypeCds->InitEditControls();
            $this->lstAuthAccountTypeCds->AddEmptyRow();
        } else {
            $this->lstAuthAccountTypeCds->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthAccountTypeCd = $this->AddWidget('AuthAccountTypeCds', 'icon-ul', $this->lstAuthAccountTypeCds);
        $wgtAuthAccountTypeCd->AddCssClass('span12');
        return $wgtAuthAccountTypeCd;
    }
    public function lstAuthAccountTypeCd_editInit() {
        //_dv($this->lstAuthAccountTypeCds->SelectedRow);
        
    }
    public function lstAuthAccountTypeCd_editSave() {
        $objAuthAccountTypeCd = AuthAccountTypeCd::LoadById($this->lstAuthAccountTypeCds->SelectedRow->ActionParameter);
        if (is_null($objAuthAccountTypeCd)) {
            $objAuthAccountTypeCd = new AuthAccountTypeCd();
        }
        $objAuthAccountTypeCd->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthAccountTypeCds->SelectedRow->UpdateEntity($objAuthAccountTypeCd);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthAccountTypeCd(AuthAccountTypeCd::LoadById($strActionParameter));
        $this->lstAuthAccountTypeCds->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthAccountTypeCd) {
        //_dv($objAuthAccountTypeCd);
        if (!is_null($this->lstAuthAccountTypeCds->SelectedRow)) {
            //This already exists
            $this->lstAuthAccountTypeCds->SelectedRow->UpdateEntity($objAuthAccountTypeCd);
            $objRow = $this->lstAuthAccountTypeCds->SelectedRow;
            $this->lstAuthAccountTypeCds->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthAccountTypeCds->AddRow($objAuthAccountTypeCd);
        }
        $this->lstAuthAccountTypeCds->RefreshControls();
        return $objRow;
    }
}
