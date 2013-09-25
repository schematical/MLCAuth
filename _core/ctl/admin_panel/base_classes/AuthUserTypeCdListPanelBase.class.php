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
* - AuthUserTypeCdListPanelBase extends MJaxTable
*/
class AuthUserTypeCdListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthUserTypeCds = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthUserTypeCds);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthUserTypeCd = AuthUserTypeCd::LoadById($strActionParameter);
        if (!is_null($objAuthUserTypeCd)) {
            $objAuthUserTypeCd->markDeleted();
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
        //$this->AddColumn('idUserTypeCd','idUserTypeCd');
        $this->AddColumn('shortDesc', ' Short Desc', null, null, 'MJaxTextBox');
    }
}
?>