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
* - lstAuthUserTypeCd_editInit()
* - lstAuthUserTypeCd_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthUserTypeCdManageFormBase extends FFSForm
*/
class AuthUserTypeCdManageFormBase extends FFSForm {
    public $lstAuthUserTypeCds = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdUserTypeCd = MLCApplication::QS(FFSQS::AuthUserTypeCd_IdUserTypeCd);
        if (!is_null($intIdUserTypeCd)) {
            $arrAndConditions[] = sprintf('AuthUserTypeCd_tpcd.idUserTypeCd = %s', $intIdUserTypeCd);
        }
        $strShortDesc = MLCApplication::QS(FFSQS::AuthUserTypeCd_ShortDesc);
        if (!is_null($strShortDesc)) {
            $arrAndConditions[] = sprintf('AuthUserTypeCd_tpcd.shortDesc LIKE "%s%%"', $strShortDesc);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthUserTypeCds = AuthUserTypeCd::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthUserTypeCds = array();
        }
        return $arrAuthUserTypeCds;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthUserTypeCdSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthUserTypeCd = $this->AddWidget('Select AuthUserTypeCd', 'icon-select', $this->pnlSelect);
        $wgtAuthUserTypeCd->AddCssClass('span6');
        return $wgtAuthUserTypeCd;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthUserTypeCds = $this->pnlSelect->GetValue();
        if (count($arrAuthUserTypeCds) == 1) {
            $this->pnlEdit->SetAuthUserTypeCd($arrAuthUserTypeCds[0]);
            foreach ($this->lstAuthUserTypeCds as $objRow) {
                if ($objRow->ActionParameter == $arrAuthUserTypeCds[0]->IdUserTypeCd) {
                    $this->lstAuthUserTypeCds->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthUserTypeCds);
        //}
        $this->lstAuthUserTypeCds->RemoveAllChildControls();
        $this->lstAuthUserTypeCds->SetDataEntites($arrAuthUserTypeCds);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthUserTypeCd = null) {
        $this->pnlEdit = new AuthUserTypeCdEditPanel($this, $objAuthUserTypeCd);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthUserTypeCd = $this->AddWidget(((is_null($objAuthUserTypeCd)) ? 'Create AuthUserTypeCd' : 'Edit AuthUserTypeCd') , 'icon-edit', $this->pnlEdit);
        $wgtAuthUserTypeCd->AddCssClass('span6');
        return $wgtAuthUserTypeCd;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthUserTypeCd) {
        $pnlRow = $this->UpdateTable($objAuthUserTypeCd);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthUserTypeCd(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthUserTypeCd) {
        $this->lstAuthUserTypeCds->SelectedRow->Remove();
        $this->lstAuthUserTypeCds->SelectedRow = null;
    }
    public function InitList($arrAuthUserTypeCds) {
        $this->lstAuthUserTypeCds = new AuthUserTypeCdListPanel($this, $arrAuthUserTypeCds);
        $this->lstAuthUserTypeCds->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthUserTypeCd_editInit'));
        $this->lstAuthUserTypeCds->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthUserTypeCd_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthUserTypeCds->InitRemoveButtons();
            $this->lstAuthUserTypeCds->InitEditControls();
            $this->lstAuthUserTypeCds->AddEmptyRow();
        } else {
            $this->lstAuthUserTypeCds->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthUserTypeCd = $this->AddWidget('AuthUserTypeCds', 'icon-ul', $this->lstAuthUserTypeCds);
        $wgtAuthUserTypeCd->AddCssClass('span12');
        return $wgtAuthUserTypeCd;
    }
    public function lstAuthUserTypeCd_editInit() {
        //_dv($this->lstAuthUserTypeCds->SelectedRow);
        
    }
    public function lstAuthUserTypeCd_editSave() {
        $objAuthUserTypeCd = AuthUserTypeCd::LoadById($this->lstAuthUserTypeCds->SelectedRow->ActionParameter);
        if (is_null($objAuthUserTypeCd)) {
            $objAuthUserTypeCd = new AuthUserTypeCd();
        }
        $objAuthUserTypeCd->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthUserTypeCds->SelectedRow->UpdateEntity($objAuthUserTypeCd);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthUserTypeCd(AuthUserTypeCd::LoadById($strActionParameter));
        $this->lstAuthUserTypeCds->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthUserTypeCd) {
        //_dv($objAuthUserTypeCd);
        if (!is_null($this->lstAuthUserTypeCds->SelectedRow)) {
            //This already exists
            $this->lstAuthUserTypeCds->SelectedRow->UpdateEntity($objAuthUserTypeCd);
            $objRow = $this->lstAuthUserTypeCds->SelectedRow;
            $this->lstAuthUserTypeCds->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthUserTypeCds->AddRow($objAuthUserTypeCd);
        }
        $this->lstAuthUserTypeCds->RefreshControls();
        return $objRow;
    }
}
