<?php
MLCApplication::InitPackage('MJaxBootstrap');
class index extends MLCForm{
    protected $objColl = null;
    protected $pnlSearch = null;
    protected $tblProfileData = null;
    protected $pnlPagination = null;

    public function Form_Create(){
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/admin/index.tpl.php';
        $this->objColl = AuthUser::Query();
        $this->objColl->Limit(10);
        $this->objColl->ExecuteQuery();

        $this->pnlSearch = new MJaxAdvSearchPanel($this);
        /*$this->pnlSearch->lstFields->AddItem(
            'User Name'
        );*/
        $this->pnlSearch->SetCollection($this->objColl);


        $this->tblProfileData = new MJaxTable($this, 'tblProfileData');
        $this->tblProfileData->AddColumn('email', 'Email');
        $this->tblProfileData->InitRowControl(
            'edit',
            'Edit',
            $this,
            'tblProfileData_edit'
        );
        $this->tblProfileData->SetCollection($this->objColl);
        $this->tblProfileData->UpdateFromCollection();

        $this->pnlPagination = new MJaxPaginationPanel($this);
        $this->pnlPagination->SetCollection($this->objColl);
        $this->pnlPagination->AddAction(
            new MJaxPaginationPanelPageChangeEvent(),
            new MJaxServerControlAction(
                $this,
                'pnlPagination_click'
            )
        );


    }
    public function tblProfileData_edit($f, $c, $ap){
        $objUser = $ap;
        $this->Redirect(
            './userDetails.php',
            array(
                'idUser'=>$objUser
            )
        );
    }
    public function pnlPagination_click($f, $c, $ap){
        $this->tblProfileData->UpdateFromCollection();

    }

}

index::Run('index');

