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
* - lstAuthSession_editInit()
* - lstAuthSession_editSave()
* - lnkEdit_click()
* - UpdateTable()
* Classes list:
* - AuthSessionManageFormBase extends FFSForm
*/
class AuthSessionManageFormBase extends FFSForm {
    public $lstAuthSessions = null;
    public $pnlEdit = null;
    public $pnlSelect = null;
    public function Form_Create() {
        parent::Form_Create();
        $this->blnSkipMainWindowRender = true;
    }
    public function Query() {
        $arrAndConditions = array();
        $intIdSession = MLCApplication::QS(FFSQS::AuthSession_IdSession);
        if (!is_null($intIdSession)) {
            $arrAndConditions[] = sprintf('AuthSession.idSession = %s', $intIdSession);
        }
        $intIdUser = MLCApplication::QS(FFSQS::AuthSession_IdUser);
        if (!is_null($intIdUser)) {
            $arrAndConditions[] = sprintf('AuthSession.idUser = %s', $intIdUser);
        }
        $strSessionKey = MLCApplication::QS(FFSQS::AuthSession_SessionKey);
        if (!is_null($strSessionKey)) {
            $arrAndConditions[] = sprintf('AuthSession.sessionKey LIKE "%s%%"', $strSessionKey);
        }
        $strIpAddress = MLCApplication::QS(FFSQS::AuthSession_IpAddress);
        if (!is_null($strIpAddress)) {
            $arrAndConditions[] = sprintf('AuthSession.ipAddress LIKE "%s%%"', $strIpAddress);
        }
        if (count($arrAndConditions) >= 1) {
            $arrAuthSessions = AuthSession::Query('WHERE ' . implode(' AND ', $arrAndConditions));
        } else {
            $arrAuthSessions = array();
        }
        return $arrAuthSessions;
    }
    public function InitSelectPanel() {
        $this->pnlSelect = new AuthSessionSelectPanel($this);
        $this->pnlSelect->AddAction(new MJaxBSAutocompleteSelectEvent() , new MJaxServerControlAction($this, 'pnlSelect_change'));
        $wgtAuthSession = $this->AddWidget('Select AuthSession', 'icon-select', $this->pnlSelect);
        $wgtAuthSession->AddCssClass('span6');
        return $wgtAuthSession;
    }
    public function pnlSelect_change($strFormId, $strControlId, $mixActionParameter) {
        $arrAuthSessions = $this->pnlSelect->GetValue();
        if (count($arrAuthSessions) == 1) {
            $this->pnlEdit->SetAuthSession($arrAuthSessions[0]);
            foreach ($this->lstAuthSessions as $objRow) {
                if ($objRow->ActionParameter == $arrAuthSessions[0]->IdSession) {
                    $this->lstAuthSessions->SelectedRow = $objRow;
                }
            }
            //$this->ScrollTo($this->pnlEdit);
            
        } //else{
        $this->ScrollTo($this->lstAuthSessions);
        //}
        $this->lstAuthSessions->RemoveAllChildControls();
        $this->lstAuthSessions->SetDataEntites($arrAuthSessions);
        //TODO: Remeber to add check lists for assoc or relationship tables
        
    }
    public function InitEditPanel($objAuthSession = null) {
        $this->pnlEdit = new AuthSessionEditPanel($this, $objAuthSession);
        $this->pnlEdit->AddAction(new MJaxDataEntitySaveEvent() , new MJaxServerControlAction($this, 'pnlEdit_save'));
        $this->pnlEdit->AddAction(new MJaxDataEntityDeleteEvent() , new MJaxServerControlAction($this, 'pnlEdit_delete'));
        $wgtAuthSession = $this->AddWidget(((is_null($objAuthSession)) ? 'Create AuthSession' : 'Edit AuthSession') , 'icon-edit', $this->pnlEdit);
        $wgtAuthSession->AddCssClass('span6');
        return $wgtAuthSession;
    }
    public function pnlEdit_save($strFormId, $strControlId, $objAuthSession) {
        $pnlRow = $this->UpdateTable($objAuthSession);
        $this->ScrollTo($pnlRow);
        $this->pnlEdit->SetAuthSession(null);
    }
    public function pnlEdit_delete($strFormId, $strControlId, $objAuthSession) {
        $this->lstAuthSessions->SelectedRow->Remove();
        $this->lstAuthSessions->SelectedRow = null;
    }
    public function InitList($arrAuthSessions) {
        $this->lstAuthSessions = new AuthSessionListPanel($this, $arrAuthSessions);
        $this->lstAuthSessions->AddAction(new MJaxTableEditInitEvent() , new MJaxServerControlAction($this, 'lstAuthSession_editInit'));
        $this->lstAuthSessions->AddAction(new MJaxTableEditSaveEvent() , new MJaxServerControlAction($this, 'lstAuthSession_editSave'));
        if ($this->blnInlineEdit) {
            $this->lstAuthSessions->InitRemoveButtons();
            $this->lstAuthSessions->InitEditControls();
            $this->lstAuthSessions->AddEmptyRow();
        } else {
            $this->lstAuthSessions->InitRowControl('edit', 'Edit', $this, 'lnkEdit_click');
        }
        //
        $wgtAuthSession = $this->AddWidget('AuthSessions', 'icon-ul', $this->lstAuthSessions);
        $wgtAuthSession->AddCssClass('span12');
        return $wgtAuthSession;
    }
    public function lstAuthSession_editInit() {
        //_dv($this->lstAuthSessions->SelectedRow);
        
    }
    public function lstAuthSession_editSave() {
        $objAuthSession = AuthSession::LoadById($this->lstAuthSessions->SelectedRow->ActionParameter);
        if (is_null($objAuthSession)) {
            $objAuthSession = new AuthSession();
        }
        $objAuthSession->IdCompetition = FFSForm::$objCompetition->IdCompetition;
        $this->lstAuthSessions->SelectedRow->UpdateEntity($objAuthSession);
    }
    public function lnkEdit_click($strFormId, $strControlId, $strActionParameter) {
        $this->pnlEdit->SetAuthSession(AuthSession::LoadById($strActionParameter));
        $this->lstAuthSessions->SelectedRow = $this->arrControls[$strControlId]->ParentControl;
        $this->ScrollTo($this->pnlEdit);
    }
    public function UpdateTable($objAuthSession) {
        //_dv($objAuthSession);
        if (!is_null($this->lstAuthSessions->SelectedRow)) {
            //This already exists
            $this->lstAuthSessions->SelectedRow->UpdateEntity($objAuthSession);
            $objRow = $this->lstAuthSessions->SelectedRow;
            $this->lstAuthSessions->SelectedRow = null;
        } else {
            $objRow = $this->lstAuthSessions->AddRow($objAuthSession);
        }
        $this->lstAuthSessions->RefreshControls();
        return $objRow;
    }
}
