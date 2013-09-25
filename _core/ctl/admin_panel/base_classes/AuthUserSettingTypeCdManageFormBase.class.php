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
* - lstAuthUserSettingTypeCd_editInit()
* - lstAuthUserSettingTypeCd_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthUserSettingTypeCdManageFormBase extends FFSForm
*/
class AuthUserSettingTypeCdManageFormBase extends FFSForm {
    public $lstAuthUserSettingTypeCds = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdUserSettingType = MLCApplication::QS(FFSQS::AuthUserSettingTypeCd_IdUserSettingType);
        if (!is_null($intIdUserSettingType)) {
            $arrAndConditions[] = sprintf('AuthUserSettingTypeCd_tpcd.idUserSettingType = %s', $intIdUserSettingType);
        }
        $strShortDesc = MLCApplication::QS(FFSQS::AuthUserSettingTypeCd_ShortDesc);
        if (!is_null($strShortDesc)) {
            $arrAndConditions[] = sprintf('AuthUserSettingTypeCd_tpcd.shortDesc LIKE "%s%%"', $strShortDesc);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthUserSettingTypeCds = AuthUserSettingTypeCd::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthUserSettingTypeCds = array();
        }
        return $arrAuthUserSettingTypeCds;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthUserSettingTypeCdSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthUserSettingTypeCd = $this->AddWidget('Select AuthUserSettingTypeCd', 'icon-select', $this->pnlSelect);
        $wgtAuthUserSettingTypeCd->AddCssClass('span6');
        return $wgtAuthUserSettingTypeCd;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthUserSettingTypeCds = $this->pnlSelect->GetValue();
        if (count($arrAuthUserSettingTypeCds) == 1) {
            $this->pnlEdit->SetAuthUserSettingTypeCd($arrAuthUserSettingTypeCds[0]);
            foreach ($this->lstAuthUserSettingTypeCds as $objRow) {
                if ($objRow->ActionParameter == $arrAuthUserSettingTypeCds[0]->IdUserSettingType) {
                    $this->lstAuthUserSettingTypeCds->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthUserSettingTypeCds);
        //}
        $this->lstAuthUserSettingTypeCds->RemoveAllChildControls();
        $this->lstAuthUserSettingTypeCds->SetDataEntites($arrAuthUserSettingTypeCds);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthUserSettingTypeCd = null) {
        $this->pnlEdit = new AuthUserSettingTypeCdEditPanel($this, $objAuthUserSettingTypeCd);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthUserSettingTypeCd = $this->AddWidget(((is_null($objAuthUserSettingTypeCd)) ? 'Create AuthUserSettingTypeCd' : 'Edit AuthUserSettingTypeCd') , 'icon-edit', $this->pnlEdit);
        $wgtAuthUserSettingTypeCd->AddCssClass('span6');
        return $wgtAuthUserSettingTypeCd;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthUserSettingTypeCd) {
        $pnlRow = $this->UpdateTable($objAuthUserSettingTypeCd);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthUserSettingTypeCd(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthUserSettingTypeCd) {
        $this->lstAuthUserSettingTypeCds->SelectedRow->Remove();
        $this->lstAuthUserSettingTypeCds->SelectedRow = null;
    }
    public function InitList($arrAuthUserSettingTypeCds) {
        $this->lstAuthUserSettingTypeCds = new AuthUserSettingTypeCdListPanel($this, $arrAuthUserSettingTypeCds);
        $this->lstAuthUserSettingTypeCds->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthUserSettingTypeCd_editInit'));
        $this->lstAuthUserSettingTypeCds->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthUserSettingTypeCd_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthUserSettingTypeCds->InitRemoveButtons();
            $this->lstAuthUserSettingTypeCds->InitEditControls();
            $this->lstAuthUserSettingTypeCds->AddEmptyRow();
        } else {
            $this->lstAuthUserSettingTypeCds->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthUserSettingTypeCd = $this->AddWidget('AuthUserSettingTypeCds', 'icon-ul', $this->lstAuthUserSettingTypeCds);
        $wgtAuthUserSettingTypeCd->AddCssClass('span12');
        return $wgtAuthUserSettingTypeCd;
    }
    public function lstAuthUserSettingTypeCd_editInit() {
        //_dv($this->lstAuthUserSettingTypeCds->SelectedRow);
        
    }
    public function lstAuthUserSettingTypeCd_editSave() {
        $objAuthUserSettingTypeCd = AuthUserSettingTypeCd::LoadById($this->lstAuthUserSettingTypeCds->SelectedRow->ActionParameter);
        if (is_null($objAuthUserSettingTypeCd)) {
            $objAuthUserSettingTypeCd = new AuthUserSettingTypeCd();
        }
        $objAuthUserSettingTypeCd->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthUserSettingTypeCds->SelectedRow->UpdateEntity($objAuthUserSettingTypeCd);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthUserSettingTypeCd(AuthUserSettingTypeCd::LoadById($strActionParameter));
        $this->lstAuthUserSettingTypeCds->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthUserSettingTypeCd) {
        //_dv($objAuthUserSettingTypeCd);
        if (!is_null($this->lstAuthUserSettingTypeCds->SelectedRow)) {
            //This already exists
            $this->lstAuthUserSettingTypeCds->SelectedRow->UpdateEntity($objAuthUserSettingTypeCd);
            $objRow = $this->lstAuthUserSettingTypeCds->SelectedRow;
            $this->lstAuthUserSettingTypeCds->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthUserSettingTypeCds->AddRow($objAuthUserSettingTypeCd);
        }
        $this->lstAuthUserSettingTypeCds->RefreshControls();
        return $objRow;
    }
}
