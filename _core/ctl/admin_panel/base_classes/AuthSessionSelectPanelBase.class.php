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
* - AuthSessionSelectPanelBase extends MJaxPanel
*/
class AuthSessionSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthSessions = array();
    public $txtSearch = null;
    //public $tblAuthSessions = null;
    public $intIdSession = null;
    public $txtStartDate_StartDate = null;
    public $txtStartDate_EndDate = null;
    public $txtEndDate_StartDate = null;
    public $txtEndDate_EndDate = null;
    public $intIdUser = null;
    public $strSessionKey = null;
    public $strIpAddress = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthSession';
        $this->txtSearch->Name = 'idAuthSession';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdSession = new MJaxTextBox($this);
        $this->intIdSession->Attr('placeholder', " Session");
        $this->txtStartDate_StartDate = new MJaxBSDateTimePicker($this);
        $this->txtStartDate_StartDate->DateOnly();
        $this->txtStartDate_EndDate = new MJaxBSDateTimePicker($this);
        $this->txtStartDate_EndDate->DateOnly();
        $this->txtEndDate_StartDate = new MJaxBSDateTimePicker($this);
        $this->txtEndDate_StartDate->DateOnly();
        $this->txtEndDate_EndDate = new MJaxBSDateTimePicker($this);
        $this->txtEndDate_EndDate->DateOnly();
        $this->intIdUser = new MJaxTextBox($this);
        $this->intIdUser->Attr('placeholder', " User");
        $this->strSessionKey = new MJaxTextBox($this);
        $this->strSessionKey->Attr('placeholder', " Session Key");
        $this->strIpAddress = new MJaxTextBox($this);
        $this->strIpAddress->Attr('placeholder', " Ip Address");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthSessions = array();
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
        $arrAuthSessions = array();
        if (is_null($objEntity)) {
            return $arrAuthSessions;
        }
        switch (get_class($objEntity)) {
            case ('AuthSession'):
                $arrAuthSessions = array(
                    $objEntity
                );
            break;
            case ('AuthUser'):
                $arrAndConditions = $this->GetExtQuery();
                $arrAndConditions[] = sprintf(' idUser = %s', $objEntity->IdUser);
                $arrAuthSessions = AuthSession::Query(' WHERE ' . implode(' AND ', $arrAndConditions));
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthSessions = $arrAuthSessions;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        //Is special field!!!!!
        if (!is_null($this->txtStartDate_StartDate->GetValue())) {
            if (is_null($this->txtStartDate_EndDate->GetValue())) {
                $this->txtStartDate_StartDate->Alert("Must have an end date to perform this function");
            } else {
                $arrAndConditions[] = sprintf('(startDate > "%s" AND startDate < "%s")', $this->txtStartDate_StartDate->GetValue() , $this->txtStartDate_EndDate->GetValue());
            }
        }
        //Is special field!!!!!
        if (!is_null($this->txtEndDate_StartDate->GetValue())) {
            if (is_null($this->txtEndDate_EndDate->GetValue())) {
                $this->txtEndDate_StartDate->Alert("Must have an end date to perform this function");
            } else {
                $arrAndConditions[] = sprintf('(endDate > "%s" AND endDate < "%s")', $this->txtEndDate_StartDate->GetValue() , $this->txtEndDate_EndDate->GetValue());
            }
        }
        //Is special field!!!!!
        if (!is_null($this->strSessionKey->GetValue())) {
            $arrAndConditions[] = sprintf('sessionKey LIKE "%s%%"', $this->strSessionKey->GetValue());
        }
        if (!is_null($this->strIpAddress->GetValue())) {
            $arrAndConditions[] = sprintf('ipAddress LIKE "%s%%"', $this->strIpAddress->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthSessions;
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
