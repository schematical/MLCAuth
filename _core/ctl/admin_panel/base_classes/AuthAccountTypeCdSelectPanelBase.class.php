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
* - AuthAccountTypeCdSelectPanelBase extends MJaxPanel
*/
class AuthAccountTypeCdSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthAccountTypeCds = array();
    public $txtSearch = null;
    //public $tblAuthAccountTypeCds = null;
    public $intIdAccountTypeCd = null;
    public $strShortDesc = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthAccountTypeCd';
        $this->txtSearch->Name = 'idAuthAccountTypeCd';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdAccountTypeCd = new MJaxTextBox($this);
        $this->intIdAccountTypeCd->Attr('placeholder', " Account Type Cd");
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Attr('placeholder', " Short Desc");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthAccountTypeCds = array();
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
        $arrAuthAccountTypeCds = array();
        if (is_null($objEntity)) {
            return $arrAuthAccountTypeCds;
        }
        switch (get_class($objEntity)) {
            case ('AuthAccountTypeCd'):
                $arrAuthAccountTypeCds = array(
                    $objEntity
                );
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthAccountTypeCds = $arrAuthAccountTypeCds;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        if (!is_null($this->strShortDesc->GetValue())) {
            $arrAndConditions[] = sprintf('shortDesc LIKE "%s%%"', $this->strShortDesc->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthAccountTypeCds;
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
