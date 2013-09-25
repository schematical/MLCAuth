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
* - lnkViewMLCLocations_click()
* Classes list:
* - AuthAccountListPanelBase extends MJaxTable
*/
class AuthAccountListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthAccounts = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthAccounts);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthAccount = AuthAccount::LoadById($strActionParameter);
        if (!is_null($objAuthAccount)) {
            $objAuthAccount->markDeleted();
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
        //$this->AddColumn('idAccount','idAccount');
        $this->AddColumn('idAccountTypeCd', ' Account Type Cd', null, null, 'MJaxTextBox');
        $this->AddColumn('shortDesc', ' Short Desc', null, null, 'MJaxTextBox');
        $this->InitRowControl('view_MLCLocations', 'View MLCLocations', $this, 'lnkViewMLCLocations_click', 'btn btn-small');
    }
    public function lnkViewMLCLocations_click($strFormId, $strControlId, $strActionParameter) {
        $this->objForm->Redirect('/data/editMLCLocation', array(
            FFSQS::AuthAccount_IdAccount => $strActionParameter
        ));
    }
}
?>