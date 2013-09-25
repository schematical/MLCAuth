<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - txtSearch_change()
* - GetExtQuery()
* - GetValue()
* - __get()
* - __set()
* Classes list:
* - AuthAccountSelectPanelBase extends MJaxPanel
*/
class AuthAccountSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthAccounts = array();
    public $txtSearch = null;
    //public $tblAuthAccounts = null;
    public $intIdAccount = null;
    public $intIdAccountTypeCd = null;
    public $intIdUser = null;
    public $strShortDesc = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthAccount';
        $this->txtSearch->Name = 'idAuthAccount';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdAccount = new MJaxTextBox($this);
        $this->intIdAccount->Attr('placeholder', " Account");
        $this->intIdAccountTypeCd = new MJaxTextBox($this);
        $this->intIdAccountTypeCd->Attr('placeholder', " Account Type Cd");
        $this->intIdUser = new MJaxTextBox($this);
        $this->intIdUser->Attr('placeholder', " User");
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Attr('placeholder', " Short Desc");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthAccounts = array();
            return;
        }
        try {
            if (class_exists($arrParts[0])) {
                $objEntity = call_user_func($arrParts[0] . '::LoadById', $arrParts[1]);
            }
        }
        catch(Exception $e) {
            error_log($e->getMessage());
        }
        $arrAuthAccounts = array();
        if (is_null($objEntity)) {
            return $arrAuthAccounts;
        }
        switch (get_class($objEntity)) {
            case ('AuthAccount'):
                $arrAuthAccounts = array(
                    $objEntity
                );
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthAccounts = $arrAuthAccounts;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        if (!is_null($this->intIdAccountTypeCd->GetValue())) {
            $arrAndConditions[] = sprintf('idAccountTypeCd LIKE "%s%%"', $this->intIdAccountTypeCd->GetValue());
        }
        //Is special field!!!!!
        //Is special field!!!!!
        //Do nothing this is a creDate
        if (!is_null($this->strShortDesc->GetValue())) {
            $arrAndConditions[] = sprintf('shortDesc LIKE "%s%%"', $this->strShortDesc->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthAccounts;
    }
    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName) {
        switch ($strName) {
            case "DisplayAdvOptions":
                return $this->blnDisplayAdvOptions;
            default:
                return parent::__get($strName);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
                
        }
    }
    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue) {
        switch ($strName) {
            case "DisplayAdvOptions":
                return $this->blnDisplayAdvOptions = $mixValue;
            default:
                return parent::__set($strName, $mixValue);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
                
        }
    }
}
