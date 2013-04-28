<?php
require_once (__MODEL_APP_API__ . "/base_classes/MLCApiAuthUserBase.class.php");
class MLCApiUser extends MLCApiUserBase{

    public function  __call($strName, $arrArguments) {



    }
    public function FinalAction($arrPostData){
        //Check the post data for email and pass
        if(
            (array_key_exists(MLCAuthQS::email, $arrPostData)) &&
            (array_key_exists(MLCAuthQS::password, $arrPostData))
        ){
            $objUser = MLCAuthDriver::Authenticate(
                $arrPostData[MLCAuthQS::email],
                $arrPostData[MLCAuthQS::password]
            );
        }elseif(
            (array_key_exists(MLCAuthQS::session, $arrPostData))
        ){
            //Check for session
            $objSession = MLCAuthDriver::LoadSession($arrPostData[MLCAuthQS::session]);
            if(!is_null($objSession)){
                $objUser = AuthUser::LoadById($objSession->IdUser);
            }
        }else{
            //See if they have a cookie
            $objUser =  MLCAuthDriver::User();
        }
        return $objUser;
    }

}