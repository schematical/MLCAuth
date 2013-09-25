<?php
MLCApplication::InitPackage('MJaxBootstrap');
class index extends MLCForm{
    protected $objUser = null;
    protected $pnlUserEdit = null;
    protected $objAuthRollColl = null;
    protected $pnlAuthRolls = null;

    public function Form_Create(){
        $intIdUser = MLCApplication::QS('idUser');
        if(is_null($intIdUser)){
            $this->Redirect('./index');
        }
        $this->objUser = AuthUser::LoadById($intIdUser);
        $this->strTemplate = __MLC_AUTH_CORE_VIEW__ . '/admin/userDetails.tpl.php';
        $this->pnlUserEdit = new AuthUserEditPanel($this);
        $this->pnlUserEdit->SetAuthUser($this->objUser);

        $this->objAuthRollColl = AuthRoll::Query();
        $this->objAuthRollColl->AddFieldCondition('AuthRoll.idAuthUser', $this->objUser->IdUser);
        $this->objAuthRollColl->ExecuteQuery();

        $this->pnlAuthRolls = new AuthRollListPanel($this);
        $this->pnlAuthRolls->EditMode = MJaxTableEditMode::INLINE;
        $this->pnlAuthRolls->SetCollection($this->objAuthRollColl);
        $this->pnlAuthRolls->UpdateFromCollection();


        $this->pnlAuthRolls->AddEmptyRow();
        $this->pnlAuthRolls->AddAction(
            new MJaxTableEditSaveEvent(),
            new MJaxServerControlAction(
                $this,
                'pnlAuthRolls_save'
            )
        );

    }
    public function pnlAuthRolls_save(){
        $objEntity = $this->pnlAuthRolls->SelectedRow->GetData('_entity');
        if(is_null($objEntity)){


            //Validate
            $this->objUser->AddRoll(


            );
        }
    }

}

index::Run('index');

