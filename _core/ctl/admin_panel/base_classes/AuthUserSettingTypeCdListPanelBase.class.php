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
* Classes list:
* - AuthUserSettingTypeCdListPanelBase extends MJaxTable
*/
class AuthUserSettingTypeCdListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthUserSettingTypeCds = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthUserSettingTypeCds);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthUserSettingTypeCd = AuthUserSettingTypeCd::LoadById($strActionParameter);
        if (!is_null($objAuthUserSettingTypeCd)) {
            $objAuthUserSettingTypeCd->markDeleted();
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
        //$this->AddColumn('idUserSettingType','idUserSettingType');
        $this->AddColumn('shortDesc', ' Short Desc', null, null, 'MJaxTextBox');
    }
}
?>