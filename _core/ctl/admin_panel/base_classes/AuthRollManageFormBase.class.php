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
* - lstAuthRoll_editInit()
* - lstAuthRoll_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthRollManageFormBase extends FFSForm
*/
class AuthRollManageFormBase extends FFSForm {
    public $lstAuthRolls = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdAuthRoll = MLCApplication::QS(FFSQS::AuthRoll_IdAuthRoll);
        if (!is_null($intIdAuthRoll)) {
            $arrAndConditions[] = sprintf('AuthRoll.idAuthRoll = %s', $intIdAuthRoll);
        }
        $strEntityType = MLCApplication::QS(FFSQS::AuthRoll_EntityType);
        if (!is_null($strEntityType)) {
            $arrAndConditions[] = sprintf('AuthRoll.entityType LIKE "%s%%"', $strEntityType);
        }
        $strRollType = MLCApplication::QS(FFSQS::AuthRoll_RollType);
        if (!is_null($strRollType)) {
            $arrAndConditions[] = sprintf('AuthRoll.rollType LIKE "%s%%"', $strRollType);
        }
        $strData = MLCApplication::QS(FFSQS::AuthRoll_Data);
        if (!is_null($strData)) {
            $arrAndConditions[] = sprintf('AuthRoll.data LIKE "%s%%"', $strData);
        }
        $strInviteEmail = MLCApplication::QS(FFSQS::AuthRoll_InviteEmail);
        if (!is_null($strInviteEmail)) {
            $arrAndConditions[] = sprintf('AuthRoll.inviteEmail LIKE "%s%%"', $strInviteEmail);
        }
        $strInviteToken = MLCApplication::QS(FFSQS::AuthRoll_InviteToken);
        if (!is_null($strInviteToken)) {
            $arrAndConditions[] = sprintf('AuthRoll.inviteToken LIKE "%s%%"', $strInviteToken);
        }
        $strIdInviteUser = MLCApplication::QS(FFSQS::AuthRoll_IdInviteUser);
        if (!is_null($strIdInviteUser)) {
            $arrAndConditions[] = sprintf('AuthRoll.idInviteUser LIKE "%s%%"', $strIdInviteUser);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthRolls = AuthRoll::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthRolls = array();
        }
        return $arrAuthRolls;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthRollSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthRoll = $this->AddWidget('Select AuthRoll', 'icon-select', $this->pnlSelect);
        $wgtAuthRoll->AddCssClass('span6');
        return $wgtAuthRoll;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthRolls = $this->pnlSelect->GetValue();
        if (count($arrAuthRolls) == 1) {
            $this->pnlEdit->SetAuthRoll($arrAuthRolls[0]);
            foreach ($this->lstAuthRolls as $objRow) {
                if ($objRow->ActionParameter == $arrAuthRolls[0]->IdAuthRoll) {
                    $this->lstAuthRolls->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthRolls);
        //}
        $this->lstAuthRolls->RemoveAllChildControls();
        $this->lstAuthRolls->SetDataEntites($arrAuthRolls);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthRoll = null) {
        $this->pnlEdit = new AuthRollEditPanel($this, $objAuthRoll);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthRoll = $this->AddWidget(((is_null($objAuthRoll)) ? 'Create AuthRoll' : 'Edit AuthRoll') , 'icon-edit', $this->pnlEdit);
        $wgtAuthRoll->AddCssClass('span6');
        return $wgtAuthRoll;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthRoll) {
        $pnlRow = $this->UpdateTable($objAuthRoll);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthRoll(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthRoll) {
        $this->lstAuthRolls->SelectedRow->Remove();
        $this->lstAuthRolls->SelectedRow = null;
    }
    public function InitList($arrAuthRolls) {
        $this->lstAuthRolls = new AuthRollListPanel($this, $arrAuthRolls);
        $this->lstAuthRolls->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthRoll_editInit'));
        $this->lstAuthRolls->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthRoll_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthRolls->InitRemoveButtons();
            $this->lstAuthRolls->InitEditControls();
            $this->lstAuthRolls->AddEmptyRow();
        } else {
            $this->lstAuthRolls->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthRoll = $this->AddWidget('AuthRolls', 'icon-ul', $this->lstAuthRolls);
        $wgtAuthRoll->AddCssClass('span12');
        return $wgtAuthRoll;
    }
    public function lstAuthRoll_editInit() {
        //_dv($this->lstAuthRolls->SelectedRow);
        
    }
    public function lstAuthRoll_editSave() {
        $objAuthRoll = AuthRoll::LoadById($this->lstAuthRolls->SelectedRow->ActionParameter);
        if (is_null($objAuthRoll)) {
            $objAuthRoll = new AuthRoll();
        }
        $objAuthRoll->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthRolls->SelectedRow->UpdateEntity($objAuthRoll);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthRoll(AuthRoll::LoadById($strActionParameter));
        $this->lstAuthRolls->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthRoll) {
        //_dv($objAuthRoll);
        if (!is_null($this->lstAuthRolls->SelectedRow)) {
            //This already exists
            $this->lstAuthRolls->SelectedRow->UpdateEntity($objAuthRoll);
            $objRow = $this->lstAuthRolls->SelectedRow;
            $this->lstAuthRolls->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthRolls->AddRow($objAuthRoll);
        }
        $this->lstAuthRolls->RefreshControls();
        return $objRow;
    }
}
