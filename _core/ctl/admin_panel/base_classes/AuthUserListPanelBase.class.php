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
* - lnkViewAuthSessions_click()
* - lnkViewAuthUserSettings_click()
* - lnkViewMLCNotifications_click()
* Classes list:
* - AuthUserListPanelBase extends MJaxTable
*/
class AuthUserListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthUsers = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthUsers);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthUser = AuthUser::LoadById($strActionParameter);
        if (!is_null($objAuthUser)) {
            $objAuthUser->markDeleted();
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
        //$this->AddColumn('idUser','idUser');
        $this->AddColumn('email', ' Email', null, null, 'MJaxTextBox');
        $this->AddColumn('password', ' Password', null, null, 'MJaxTextBox');
        $this->AddColumn('idAccount', ' Account', null, null, 'MJaxTextBox');
        $this->AddColumn('idUserTypeCd', ' User Type Cd', null, null, 'MJaxTextBox');
        $this->AddColumn('username', ' Username', null, null, 'MJaxTextBox');
        $this->AddColumn('passResetCode', ' Pass Reset Code', null, null, 'MJaxTextBox');
        $this->AddColumn('fbuid', ' Fbuid', null, null, 'MJaxTextBox');
        $this->AddColumn('fbAccessToken', ' Fb Access Token', null, null, 'MJaxTextBox');
        $this->AddColumn('active', ' Active', null, null, 'MJaxTextBox');
        $this->AddColumn('friendsIds', ' Friends Ids', null, null, 'MJaxTextArea');
        $this->AddColumn('friendsUpdated', ' Friends Updated', null, null, 'MJaxTextBox');
        $this->AddColumn('fbAccessTokenExpires', ' Fb Access Token Expires', null, null, 'MJaxTextBox');
        $this->InitRowControl('view_AuthSessions', 'View AuthSessions', $this, 'lnkViewAuthSessions_click', 'btn btn-small');
        $this->InitRowControl('view_AuthUserSettings', 'View AuthUserSettings', $this, 'lnkViewAuthUserSettings_click', 'btn btn-small');
        $this->InitRowControl('view_MLCNotifications', 'View MLCNotifications', $this, 'lnkViewMLCNotifications_click', 'btn btn-small');
    }
    public function lnkViewAuthSessions_click($strFormId, $strControlId, $strActionParameter) {
        $this->objForm->Redirect('/data/editAuthSession', array(
            FFSQS::AuthUser_IdUser => $strActionParameter
        ));
    }
    public function lnkViewAuthUserSettings_click($strFormId, $strControlId, $strActionParameter) {
        $this->objForm->Redirect('/data/editAuthUserSetting', array(
            FFSQS::AuthUser_IdUser => $strActionParameter
        ));
    }
    public function lnkViewMLCNotifications_click($strFormId, $strControlId, $strActionParameter) {
        $this->objForm->Redirect('/data/editMLCNotification', array(
            FFSQS::AuthUser_IdUser => $strActionParameter
        ));
    }
}
?>