<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - InitRemoveButtons()
* - lnkRemove_click()
* - RenderDate()
* - RenderTime()
* - SetupCols()
* - lnkViewTrackingEvents_click()
* - render_idUser()
* Classes list:
* - AuthSessionListPanelBase extends MJaxTable
*/
class AuthSessionListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthSessions = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthSessions);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthSession = AuthSession::LoadById($strActionParameter);
        if (!is_null($objAuthSession)) {
            $objAuthSession->markDeleted();
        }
        foreach ($this->Rows as $intIndex => $objRow) {
            if ($objRow->ActionParameter == $strActionParameter) {
                $objRow->Remove();
                //unset($this->Rows[$intIndex]);
                $this->blnModified = true;
                return;
            }
        }
    }
    public function RenderDate($strData, $objRow) {
        return date_format(new DateTime($strData) , 'm/d/y');
    }
    public function RenderTime($strData, $objRow) {
        return date_format(new DateTime($strData) , 'h:i');
    }
    public function SetupCols() {
        //$this->AddColumn('idSession','idSession');
        $this->AddColumn('IdUserObject', ' User');
        $this->AddColumn('sessionKey', ' Session Key', null, null, 'MJaxTextBox');
        $this->AddColumn('ipAddress', ' Ip Address', null, null, 'MJaxTextBox');
        $this->InitRowControl('view_TrackingEvents', 'View TrackingEvents', $this, 'lnkViewTrackingEvents_click', 'btn btn-small');
    }
    public function lnkViewTrackingEvents_click($strFormId, $strControlId, $strActionParameter) {
        $this->objForm->Redirect('/data/editTrackingEvent', array(
            FFSQS::AuthSession_IdSession => $strActionParameter
        ));
    }
    public function render_idUser($intIdIdUser, $objRow, $objColumn) {
        if (is_null($intIdIdUser)) {
            return '';
        }
        $objAuthUser = AuthUser::LoadById($intIdIdUser);
        if (is_null($objAuthUser)) {
            return 'error';
        }
        $lnkView = new MJaxLinkButton($this);
        $lnkView->Text = $objAuthUser->__toString();
        $lnkView->Href = '/data/editAuthUser?' . FFSQS::AuthUser_IdUser . '=' . $objAuthUser->IdUser;
        return $lnkView->Render(false);
    }
}
?>