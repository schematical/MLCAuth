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
* - AuthUserSettingSelectPanelBase extends MJaxPanel
*/
class AuthUserSettingSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthUserSettings = array();
    public $txtSearch = null;
    //public $tblAuthUserSettings = null;
    public $intIdUserSetting = null;
    public $intIdUser = null;
    public $intIdUserSettingTypeCd = null;
    public $strData = null;
    public $strNamespace = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthUserSetting';
        $this->txtSearch->Name = 'idAuthUserSetting';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdUserSetting = new MJaxTextBox($this);
        $this->intIdUserSetting->Attr('placeholder', " User Setting");
        $this->intIdUser = new MJaxTextBox($this);
        $this->intIdUser->Attr('placeholder', " User");
        $this->intIdUserSettingTypeCd = new MJaxTextBox($this);
        $this->intIdUserSettingTypeCd->Attr('placeholder', " User Setting Type Cd");
        $this->strData = new MJaxTextBox($this);
        $this->strData->Attr('placeholder', " Data");
        $this->strNamespace = new MJaxTextBox($this);
        $this->strNamespace->Attr('placeholder', " Namespace");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthUserSettings = array();
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
        $arrAuthUserSettings = array();
        if (is_null($objEntity)) {
            return $arrAuthUserSettings;
        }
        switch (get_class($objEntity)) {
            case ('AuthUserSetting'):
                $arrAuthUserSettings = array(
                    $objEntity
                );
            break;
            case ('AuthUser'):
                $arrAndConditions = $this->GetExtQuery();
                $arrAndConditions[] = sprintf(' idUser = %s', $objEntity->IdUser);
                $arrAuthUserSettings = AuthUserSetting::Query(' WHERE ' . implode(' AND ', $arrAndConditions));
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthUserSettings = $arrAuthUserSettings;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        //Is special field!!!!!
        if (!is_null($this->intIdUserSettingTypeCd->GetValue())) {
            $arrAndConditions[] = sprintf('idUserSettingTypeCd LIKE "%s%%"', $this->intIdUserSettingTypeCd->GetValue());
        }
        //Is special field!!!!!
        if (!is_null($this->strNamespace->GetValue())) {
            $arrAndConditions[] = sprintf('namespace LIKE "%s%%"', $this->strNamespace->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthUserSettings;
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
