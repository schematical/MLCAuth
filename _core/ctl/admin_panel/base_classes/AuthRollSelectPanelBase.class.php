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
* - AuthRollSelectPanelBase extends MJaxPanel
*/
class AuthRollSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthRolls = array();
    public $txtSearch = null;
    //public $tblAuthRolls = null;
    public $intIdAuthRoll = null;
    public $intIdAuthUser = null;
    public $intIdEntity = null;
    public $strEntityType = null;
    public $strRollType = null;
    public $strData = null;
    public $strInviteEmail = null;
    public $strInviteToken = null;
    public $strIdInviteUser = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthRoll';
        $this->txtSearch->Name = 'idAuthRoll';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdAuthRoll = new MJaxTextBox($this);
        $this->intIdAuthRoll->Attr('placeholder', " Auth Roll");
        $this->intIdAuthUser = new MJaxTextBox($this);
        $this->intIdAuthUser->Attr('placeholder', " Auth User");
        $this->intIdEntity = new MJaxTextBox($this);
        $this->intIdEntity->Attr('placeholder', " Entity");
        $this->strEntityType = new MJaxTextBox($this);
        $this->strEntityType->Attr('placeholder', " Entity Type");
        $this->strRollType = new MJaxTextBox($this);
        $this->strRollType->Attr('placeholder', " Roll Type");
        $this->strData = new MJaxTextBox($this);
        $this->strData->Attr('placeholder', " Data");
        $this->strInviteEmail = new MJaxTextBox($this);
        $this->strInviteEmail->Attr('placeholder', " Invite Email");
        $this->strInviteToken = new MJaxTextBox($this);
        $this->strInviteToken->Attr('placeholder', " Invite Token");
        $this->strIdInviteUser = new MJaxTextBox($this);
        $this->strIdInviteUser->Attr('placeholder', " Invite User");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthRolls = array();
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
        $arrAuthRolls = array();
        if (is_null($objEntity)) {
            return $arrAuthRolls;
        }
        switch (get_class($objEntity)) {
            case ('AuthRoll'):
                $arrAuthRolls = array(
                    $objEntity
                );
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthRolls = $arrAuthRolls;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        if (!is_null($this->intIdAuthUser->GetValue())) {
            $arrAndConditions[] = sprintf('idAuthUser LIKE "%s%%"', $this->intIdAuthUser->GetValue());
        }
        if (!is_null($this->intIdEntity->GetValue())) {
            $arrAndConditions[] = sprintf('idEntity LIKE "%s%%"', $this->intIdEntity->GetValue());
        }
        //Is special field!!!!!
        //Do nothing this is a creDate
        if (!is_null($this->strEntityType->GetValue())) {
            $arrAndConditions[] = sprintf('entityType LIKE "%s%%"', $this->strEntityType->GetValue());
        }
        if (!is_null($this->strRollType->GetValue())) {
            $arrAndConditions[] = sprintf('rollType LIKE "%s%%"', $this->strRollType->GetValue());
        }
        //Is special field!!!!!
        if (!is_null($this->strInviteEmail->GetValue())) {
            $arrAndConditions[] = sprintf('inviteEmail LIKE "%s%%"', $this->strInviteEmail->GetValue());
        }
        if (!is_null($this->strInviteToken->GetValue())) {
            $arrAndConditions[] = sprintf('inviteToken LIKE "%s%%"', $this->strInviteToken->GetValue());
        }
        if (!is_null($this->strIdInviteUser->GetValue())) {
            $arrAndConditions[] = sprintf('idInviteUser LIKE "%s%%"', $this->strIdInviteUser->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthRolls;
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
