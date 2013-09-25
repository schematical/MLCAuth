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
* - AuthUserTypeCdSelectPanelBase extends MJaxPanel
*/
class AuthUserTypeCdSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthUserTypeCds = array();
    public $txtSearch = null;
    //public $tblAuthUserTypeCds = null;
    public $intIdUserTypeCd = null;
    public $strShortDesc = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthUserTypeCd';
        $this->txtSearch->Name = 'idAuthUserTypeCd';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdUserTypeCd = new MJaxTextBox($this);
        $this->intIdUserTypeCd->Attr('placeholder', " User Type Cd");
        $this->strShortDesc = new MJaxTextBox($this);
        $this->strShortDesc->Attr('placeholder', " Short Desc");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthUserTypeCds = array();
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
        $arrAuthUserTypeCds = array();
        if (is_null($objEntity)) {
            return $arrAuthUserTypeCds;
        }
        switch (get_class($objEntity)) {
            case ('AuthUserTypeCd'):
                $arrAuthUserTypeCds = array(
                    $objEntity
                );
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthUserTypeCds = $arrAuthUserTypeCds;
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
        return $this->arrSelectedAuthUserTypeCds;
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
