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
* - AuthUserSelectPanelBase extends MJaxPanel
*/
class AuthUserSelectPanelBase extends MJaxPanel {
    protected $blnDisplayAdvOptions = false;
    protected $arrSelectedAuthUsers = array();
    public $txtSearch = null;
    //public $tblAuthUsers = null;
    public $intIdUser = null;
    public $strEmail = null;
    public $strPassword = null;
    public $intIdAccount = null;
    public $intIdUserTypeCd = null;
    public $strUsername = null;
    public $strPassResetCode = null;
    public $strFbuid = null;
    public $strFbAccessToken = null;
    public $intActive = null;
    public $strFriendsIds = null;
    public $dttFriendsUpdated = null;
    public $intFbAccessTokenExpires = null;
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/' . get_class($this) . '.tpl.php';
        $this->txtSearch = new MJaxBSAutocompleteTextBox($this);
        $this->txtSearch->Url = '/data/search?mjax-route-ext=AuthUser';
        $this->txtSearch->Name = 'idAuthUser';
        $this->txtSearch->AddCssClass('input-large');
        $this->txtSearch->AddAction(new MJaxChangeEvent() , new MJaxServerControlAction($this, 'txtSearch_change'));
        $this->intIdUser = new MJaxTextBox($this);
        $this->intIdUser->Attr('placeholder', " User");
        $this->strEmail = new MJaxTextBox($this);
        $this->strEmail->Attr('placeholder', " Email");
        $this->strPassword = new MJaxTextBox($this);
        $this->strPassword->Attr('placeholder', " Password");
        $this->intIdAccount = new MJaxTextBox($this);
        $this->intIdAccount->Attr('placeholder', " Account");
        $this->intIdUserTypeCd = new MJaxTextBox($this);
        $this->intIdUserTypeCd->Attr('placeholder', " User Type Cd");
        $this->strUsername = new MJaxTextBox($this);
        $this->strUsername->Attr('placeholder', " Username");
        $this->strPassResetCode = new MJaxTextBox($this);
        $this->strPassResetCode->Attr('placeholder', " Pass Reset Code");
        $this->strFbuid = new MJaxTextBox($this);
        $this->strFbuid->Attr('placeholder', " Fbuid");
        $this->strFbAccessToken = new MJaxTextBox($this);
        $this->strFbAccessToken->Attr('placeholder', " Fb Access Token");
        $this->intActive = new MJaxTextBox($this);
        $this->intActive->Attr('placeholder', " Active");
        $this->strFriendsIds = new MJaxTextBox($this);
        $this->strFriendsIds->Attr('placeholder', " Friends Ids");
        $this->dttFriendsUpdated = new MJaxTextBox($this);
        $this->dttFriendsUpdated->Attr('placeholder', " Friends Updated");
        $this->intFbAccessTokenExpires = new MJaxTextBox($this);
        $this->intFbAccessTokenExpires->Attr('placeholder', " Fb Access Token Expires");
    }
    public function txtSearch_change() {
        $objEntity = null;
        $arrParts = explode('_', $this->txtSearch->Value);
        if (count($arrParts) < 2) {
            //IDK
            $this->arrSelectedAuthUsers = array();
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
        $arrAuthUsers = array();
        if (is_null($objEntity)) {
            return $arrAuthUsers;
        }
        switch (get_class($objEntity)) {
            case ('AuthUser'):
                $arrAuthUsers = array(
                    $objEntity
                );
            break;
            default:
                array();
                throw new Exception("Invalid entity type: " . get_class($objEntity));
        }
        $this->arrSelectedAuthUsers = $arrAuthUsers;
        $this->TriggerEvent('mjax-bs-autocomplete-select');
    }
    public function GetExtQuery() {
        $arrAndConditions = array();
        if (!is_null($this->strEmail->GetValue())) {
            $arrAndConditions[] = sprintf('email LIKE "%s%%"', $this->strEmail->GetValue());
        }
        if (!is_null($this->strPassword->GetValue())) {
            $arrAndConditions[] = sprintf('password LIKE "%s%%"', $this->strPassword->GetValue());
        }
        if (!is_null($this->intIdAccount->GetValue())) {
            $arrAndConditions[] = sprintf('idAccount LIKE "%s%%"', $this->intIdAccount->GetValue());
        }
        if (!is_null($this->intIdUserTypeCd->GetValue())) {
            $arrAndConditions[] = sprintf('idUserTypeCd LIKE "%s%%"', $this->intIdUserTypeCd->GetValue());
        }
        if (!is_null($this->strUsername->GetValue())) {
            $arrAndConditions[] = sprintf('username LIKE "%s%%"', $this->strUsername->GetValue());
        }
        if (!is_null($this->strPassResetCode->GetValue())) {
            $arrAndConditions[] = sprintf('passResetCode LIKE "%s%%"', $this->strPassResetCode->GetValue());
        }
        if (!is_null($this->strFbuid->GetValue())) {
            $arrAndConditions[] = sprintf('fbuid LIKE "%s%%"', $this->strFbuid->GetValue());
        }
        if (!is_null($this->strFbAccessToken->GetValue())) {
            $arrAndConditions[] = sprintf('fbAccessToken LIKE "%s%%"', $this->strFbAccessToken->GetValue());
        }
        if (!is_null($this->intActive->GetValue())) {
            $arrAndConditions[] = sprintf('active LIKE "%s%%"', $this->intActive->GetValue());
        }
        if (!is_null($this->strFriendsIds->GetValue())) {
            $arrAndConditions[] = sprintf('friendsIds LIKE "%s%%"', $this->strFriendsIds->GetValue());
        }
        if (!is_null($this->dttFriendsUpdated->GetValue())) {
            $arrAndConditions[] = sprintf('friendsUpdated LIKE "%s%%"', $this->dttFriendsUpdated->GetValue());
        }
        if (!is_null($this->intFbAccessTokenExpires->GetValue())) {
            $arrAndConditions[] = sprintf('fbAccessTokenExpires LIKE "%s%%"', $this->intFbAccessTokenExpires->GetValue());
        }
        return $arrAndConditions;
    }
    public function GetValue() {
        return $this->arrSelectedAuthUsers;
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
