<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MLCResetPasswordPanel extends QPanel{
    const QS_HASH = 'x';
    const QS_USER_ID = 'id';
    public function __construct($objParentObject,$strControlId = null) {
        parent::__construct($objParentObject,$strControlId);

        $strHash = QApplication::QueryString(self::QS_HASH);
        $intId = QApplication::QueryString(self::QS_USER_ID);
        if((!is_null($intId)) ||(!is_numeric($intId))){
            $objUser = User::Load($intId);
            if(!is_null($objUser)){
               QApplication::Redirect('/');
            }
            if($strHash == MLCAuthDriver::HashPass($objUser->Email . $objUser->Password)){
                $objUser->Password = MLCAuthDriver::GenRandomString();
                $objUser->Save();
                $arrVars = array(
                    "_EMAIL"=>$objUser->Email,
                    "_PASS"=>$objUser->Password
                );
                $strEmailBody = MLCAssetDriver::EvaluateTemplate(__FORGOT_PASS_EMAIL__, $arrVars);
                $objMessage = new QEmailMessage($objEmailConfig, $objUser->Email);

                QEmailServer::Send($objMessage);
            }
        }else{
            QApplication::Redirect('/');
        }
    }
}
?>
