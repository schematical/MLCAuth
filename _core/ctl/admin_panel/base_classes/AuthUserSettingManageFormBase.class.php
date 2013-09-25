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
* - lstAuthUserSetting_editInit()
* - lstAuthUserSetting_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthUserSettingManageFormBase extends FFSForm
*/
class AuthUserSettingManageFormBase extends FFSForm {
    public $lstAuthUserSettings = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdUserSetting = MLCApplication::QS(FFSQS::AuthUserSetting_IdUserSetting);
        if (!is_null($intIdUserSetting)) {
            $arrAndConditions[] = sprintf('AuthUserSetting.idUserSetting = %s', $intIdUserSetting);
        }
        $intIdUser = MLCApplication::QS(FFSQS::AuthUserSetting_IdUser);
        if (!is_null($intIdUser)) {
            $arrAndConditions[] = sprintf('AuthUserSetting.idUser = %s', $intIdUser);
        }
        $strNamespace = MLCApplication::QS(FFSQS::AuthUserSetting_Namespace);
        if (!is_null($strNamespace)) {
            $arrAndConditions[] = sprintf('AuthUserSetting.namespace LIKE "%s%%"', $strNamespace);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthUserSettings = AuthUserSetting::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthUserSettings = array();
        }
        return $arrAuthUserSettings;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthUserSettingSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthUserSetting = $this->AddWidget('Select AuthUserSetting', 'icon-select', $this->pnlSelect);
        $wgtAuthUserSetting->AddCssClass('span6');
        return $wgtAuthUserSetting;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthUserSettings = $this->pnlSelect->GetValue();
        if (count($arrAuthUserSettings) == 1) {
            $this->pnlEdit->SetAuthUserSetting($arrAuthUserSettings[0]);
            foreach ($this->lstAuthUserSettings as $objRow) {
                if ($objRow->ActionParameter == $arrAuthUserSettings[0]->IdUserSetting) {
                    $this->lstAuthUserSettings->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthUserSettings);
        //}
        $this->lstAuthUserSettings->RemoveAllChildControls();
        $this->lstAuthUserSettings->SetDataEntites($arrAuthUserSettings);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthUserSetting = null) {
        $this->pnlEdit = new AuthUserSettingEditPanel($this, $objAuthUserSetting);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthUserSetting = $this->AddWidget(((is_null($objAuthUserSetting)) ? 'Create AuthUserSetting' : 'Edit AuthUserSetting') , 'icon-edit', $this->pnlEdit);
        $wgtAuthUserSetting->AddCssClass('span6');
        return $wgtAuthUserSetting;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthUserSetting) {
        $pnlRow = $this->UpdateTable($objAuthUserSetting);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthUserSetting(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthUserSetting) {
        $this->lstAuthUserSettings->SelectedRow->Remove();
        $this->lstAuthUserSettings->SelectedRow = null;
    }
    public function InitList($arrAuthUserSettings) {
        $this->lstAuthUserSettings = new AuthUserSettingListPanel($this, $arrAuthUserSettings);
        $this->lstAuthUserSettings->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthUserSetting_editInit'));
        $this->lstAuthUserSettings->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthUserSetting_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthUserSettings->InitRemoveButtons();
            $this->lstAuthUserSettings->InitEditControls();
            $this->lstAuthUserSettings->AddEmptyRow();
        } else {
            $this->lstAuthUserSettings->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthUserSetting = $this->AddWidget('AuthUserSettings', 'icon-ul', $this->lstAuthUserSettings);
        $wgtAuthUserSetting->AddCssClass('span12');
        return $wgtAuthUserSetting;
    }
    public function lstAuthUserSetting_editInit() {
        //_dv($this->lstAuthUserSettings->SelectedRow);
        
    }
    public function lstAuthUserSetting_editSave() {
        $objAuthUserSetting = AuthUserSetting::LoadById($this->lstAuthUserSettings->SelectedRow->ActionParameter);
        if (is_null($objAuthUserSetting)) {
            $objAuthUserSetting = new AuthUserSetting();
        }
        $objAuthUserSetting->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthUserSettings->SelectedRow->UpdateEntity($objAuthUserSetting);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthUserSetting(AuthUserSetting::LoadById($strActionParameter));
        $this->lstAuthUserSettings->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthUserSetting) {
        //_dv($objAuthUserSetting);
        if (!is_null($this->lstAuthUserSettings->SelectedRow)) {
            //This already exists
            $this->lstAuthUserSettings->SelectedRow->UpdateEntity($objAuthUserSetting);
            $objRow = $this->lstAuthUserSettings->SelectedRow;
            $this->lstAuthUserSettings->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthUserSettings->AddRow($objAuthUserSetting);
        }
        $this->lstAuthUserSettings->RefreshControls();
        return $objRow;
    }
}
