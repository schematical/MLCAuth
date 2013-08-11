<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - CreateContentControls()
* - CreateFieldControls()
* - CreateReferenceControls()
* - btnSave_click()
* - btnDelete_click()
* - IsNew()
* Classes list:
* - EditPanelBase extends MJaxPanel
*/
class EditPanelBase extends MJaxPanel {
    protected $obj = null;
    //Regular controls
    public $btnSave = null;
    public $btnDelete = null;
    public function __construct($objParentControl, $obj = null) {
        parent::__construct($objParentControl);
        $this->obj = $obj;
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/ctl_panels/EditPanelBase.tpl.php';
        $this->CreateFieldControls();
        $this->CreateContentControls();
        $this->CreateReferenceControls();
    }
    public function CreateContentControls() {
        $this->btnSave = new MJaxButton($this);
        $this->btnSave->Text = 'Save';
        $this->btnSave->AddAction(new MJaxClickEvent() , new MJaxServerControlAction($this, 'btnSave_click'));
        $this->btnDelete = new MJaxButton($this);
        $this->btnDelete->Text = 'Delete';
        $this->btnDelete->AddAction(new MJaxClickEvent() , new MJaxServerControlAction($this, 'btnDelete_click'));
        if (is_null($this->obj)) {
            $this->btnDelete->Style->Display = 'none';
        }
    }
    public function CreateFieldControls() {
        if (!is_null($this->obj)) {
        }
    }
    public function CreateReferenceControls() {
        // if(!is_null($this->obj->i)){
        // }
        
    }
    public function btnSave_click() {
        if (is_null($this->obj)) {
            //Create a new one
            $this->obj = new ();
        }
        $this->obj->Save();
    }
    public function btnDelete_click() {
        $this->obj->Delete();
    }
    public function IsNew() {
        return is_null($this->obj);
    }
}
?>