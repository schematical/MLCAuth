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
* - render_idUser()
* Classes list:
* - AuthUserSettingListPanelBase extends MJaxTable
*/
class AuthUserSettingListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthUserSettings = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthUserSettings);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthUserSetting = AuthUserSetting::LoadById($strActionParameter);
        if (!is_null($objAuthUserSetting)) {
            $objAuthUserSetting->markDeleted();
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
        //$this->AddColumn('idUserSetting','idUserSetting');
        $this->AddColumn('IdUserObject', ' User');
        $this->AddColumn('idUserSettingTypeCd', ' User Setting Type Cd', null, null, 'MJaxTextBox');
        $this->AddColumn('namespace', ' Namespace', null, null, 'MJaxTextBox');
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