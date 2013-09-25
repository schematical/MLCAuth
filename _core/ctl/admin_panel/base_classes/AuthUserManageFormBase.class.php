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
* - lstAuthUser_editInit()
* - lstAuthUser_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthUserManageFormBase extends FFSForm
*/
class AuthUserManageFormBase extends FFSForm {
    public $lstAuthUsers = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdUser = MLCApplication::QS(FFSQS::AuthUser_IdUser);
        if (!is_null($intIdUser)) {
            $arrAndConditions[] = sprintf('AuthUser.idUser = %s', $intIdUser);
        }
        $strEmail = MLCApplication::QS(FFSQS::AuthUser_Email);
        if (!is_null($strEmail)) {
            $arrAndConditions[] = sprintf('AuthUser.email LIKE "%s%%"', $strEmail);
        }
        $strPassword = MLCApplication::QS(FFSQS::AuthUser_Password);
        if (!is_null($strPassword)) {
            $arrAndConditions[] = sprintf('AuthUser.password LIKE "%s%%"', $strPassword);
        }
        $strUsername = MLCApplication::QS(FFSQS::AuthUser_Username);
        if (!is_null($strUsername)) {
            $arrAndConditions[] = sprintf('AuthUser.username LIKE "%s%%"', $strUsername);
        }
        $strPassResetCode = MLCApplication::QS(FFSQS::AuthUser_PassResetCode);
        if (!is_null($strPassResetCode)) {
            $arrAndConditions[] = sprintf('AuthUser.passResetCode LIKE "%s%%"', $strPassResetCode);
        }
        $strFbuid = MLCApplication::QS(FFSQS::AuthUser_Fbuid);
        if (!is_null($strFbuid)) {
            $arrAndConditions[] = sprintf('AuthUser.fbuid LIKE "%s%%"', $strFbuid);
        }
        $strFbAccessToken = MLCApplication::QS(FFSQS::AuthUser_FbAccessToken);
        if (!is_null($strFbAccessToken)) {
            $arrAndConditions[] = sprintf('AuthUser.fbAccessToken LIKE "%s%%"', $strFbAccessToken);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthUsers = AuthUser::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthUsers = array();
        }
        return $arrAuthUsers;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthUserSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthUser = $this->AddWidget('Select AuthUser', 'icon-select', $this->pnlSelect);
        $wgtAuthUser->AddCssClass('span6');
        return $wgtAuthUser;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthUsers = $this->pnlSelect->GetValue();
        if (count($arrAuthUsers) == 1) {
            $this->pnlEdit->SetAuthUser($arrAuthUsers[0]);
            foreach ($this->lstAuthUsers as $objRow) {
                if ($objRow->ActionParameter == $arrAuthUsers[0]->IdUser) {
                    $this->lstAuthUsers->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthUsers);
        //}
        $this->lstAuthUsers->RemoveAllChildControls();
        $this->lstAuthUsers->SetDataEntites($arrAuthUsers);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthUser = null) {
        $this->pnlEdit = new AuthUserEditPanel($this, $objAuthUser);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthUser = $this->AddWidget(((is_null($objAuthUser)) ? 'Create AuthUser' : 'Edit AuthUser') , 'icon-edit', $this->pnlEdit);
        $wgtAuthUser->AddCssClass('span6');
        return $wgtAuthUser;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthUser) {
        $pnlRow = $this->UpdateTable($objAuthUser);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthUser(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthUser) {
        $this->lstAuthUsers->SelectedRow->Remove();
        $this->lstAuthUsers->SelectedRow = null;
    }
    public function InitList($arrAuthUsers) {
        $this->lstAuthUsers = new AuthUserListPanel($this, $arrAuthUsers);
        $this->lstAuthUsers->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthUser_editInit'));
        $this->lstAuthUsers->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthUser_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthUsers->InitRemoveButtons();
            $this->lstAuthUsers->InitEditControls();
            $this->lstAuthUsers->AddEmptyRow();
        } else {
            $this->lstAuthUsers->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthUser = $this->AddWidget('AuthUsers', 'icon-ul', $this->lstAuthUsers);
        $wgtAuthUser->AddCssClass('span12');
        return $wgtAuthUser;
    }
    public function lstAuthUser_editInit() {
        //_dv($this->lstAuthUsers->SelectedRow);
        
    }
    public function lstAuthUser_editSave() {
        $objAuthUser = AuthUser::LoadById($this->lstAuthUsers->SelectedRow->ActionParameter);
        if (is_null($objAuthUser)) {
            $objAuthUser = new AuthUser();
        }
        $objAuthUser->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthUsers->SelectedRow->UpdateEntity($objAuthUser);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthUser(AuthUser::LoadById($strActionParameter));
        $this->lstAuthUsers->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthUser) {
        //_dv($objAuthUser);
        if (!is_null($this->lstAuthUsers->SelectedRow)) {
            //This already exists
            $this->lstAuthUsers->SelectedRow->UpdateEntity($objAuthUser);
            $objRow = $this->lstAuthUsers->SelectedRow;
            $this->lstAuthUsers->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthUsers->AddRow($objAuthUser);
        }
        $this->lstAuthUsers->RefreshControls();
        return $objRow;
    }
}
