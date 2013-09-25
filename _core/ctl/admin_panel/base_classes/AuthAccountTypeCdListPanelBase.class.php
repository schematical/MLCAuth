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
* - AuthAccountTypeCdListPanelBase extends MJaxTable
*/
class AuthAccountTypeCdListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthAccountTypeCds = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthAccountTypeCds);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthAccountTypeCd = AuthAccountTypeCd::LoadById($strActionParameter);
        if (!is_null($objAuthAccountTypeCd)) {
            $objAuthAccountTypeCd->markDeleted();
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
        //$this->AddColumn('idAccountTypeCd','idAccountTypeCd');
        $this->AddColumn('shortDesc', ' Short Desc', null, null, 'MJaxTextBox');
    }
}
?>