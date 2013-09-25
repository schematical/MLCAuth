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
* - AuthRollListPanelBase extends MJaxTable
*/
class AuthRollListPanelBase extends MJaxTable {
    public function __construct($objParentControl, $arrAuthRolls = array()) {
        parent::__construct($objParentControl);
        $this->SetupCols();
        $this->SetDataEntites($arrAuthRolls);
    }
    public function InitRemoveButtons($strText = 'Remove', $strCssClasses = 'btn btn-error') {
        $this->InitRowControl('remove', $strText, $this, 'lnkRemove_click', $strCssClasses);
    }
    public function lnkRemove_click($strFormId, $strControlId, $strActionParameter) {
        //_dv($strActionParameter);
        $objAuthRoll = AuthRoll::LoadById($strActionParameter);
        if (!is_null($objAuthRoll)) {
            $objAuthRoll->markDeleted();
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
        //$this->AddColumn('idAuthRoll','idAuthRoll');
        $this->AddColumn('idAuthUser', ' Auth User', null, null, 'MJaxTextBox');
        $this->AddColumn('idEntity', ' Entity', null, null, 'MJaxTextBox');
        $this->AddColumn('entityType', ' Entity Type', null, null, 'MJaxTextBox');
        $this->AddColumn('rollType', ' Roll Type', null, null, 'MJaxTextBox');
        $this->AddColumn('inviteEmail', ' Invite Email', null, null, 'MJaxTextBox');
        $this->AddColumn('inviteToken', ' Invite Token', null, null, 'MJaxTextBox');
        $this->AddColumn('idInviteUser', ' Invite User', null, null, 'MJaxTextBox');
    }
}
?>