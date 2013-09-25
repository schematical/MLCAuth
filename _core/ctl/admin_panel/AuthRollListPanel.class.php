<?php
require_once(__MLC_AUTH_CORE_CTL__ . "/admin_panel/base_classes/AuthRollListPanelBase.class.php");
class AuthRollListPanel extends AuthRollListPanelBase {
    protected $lstRollType = null;
    protected $lstEntity = null;

    public function __construct($objParentControl, $arrAuthRolls = array()){

		parent::__construct($objParentControl, $arrAuthRolls = array());
        $this->AddCssClass('table table-striped table-bordered');
        $this->lstRollType = new MJaxListBox($this);



	}
    public function AddRollType($strRollType, $strName){
        $this->lstRollType->AddItem($strRollType, $strName);
    }
    public function colEntity_render($strData, $objRow, $objCol){
        $objRoll = $objRow->GetData('_entity');

        if(is_null($objRoll)){
            return '';
        }
        return $objRoll->GetEntity()->__toString();
    }
	public function SetupCols(){
        $colUser = $this->AddColumn('IdAuthUserObject','User');
        $colEntity = $this->AddColumn('idEntity','Entity');
        $colEntity->RenderObject = $this;
        $colEntity->RenderFunction = 'colEntity_render';
        $colEntity->EditCtlInitMethod = 'colEntity_initEdit';

        $colCreDate = $this->AddColumn('creDate','Cre Date');
        $colRollType = $this->AddColumn('rollType','rollType');
        $colRollType->EditCtlInitMethod = 'colRollType_initEdit';


    }
    public function colEntity_initEdit($strData, $objRow, $objCol){

    }
    public function colRollType_initEdit($strData, $objRow, $objCol){
        return $this->lstRollType->Render(false);
    }




}


?>