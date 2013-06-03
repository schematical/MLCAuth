<?php
require_once (__MLC_AUTH_CORE_API__ . "/base_classes/MLCApiAuthUserBase.class.php");

class MLCApiAuthUser extends MLCApiAuthUserBase{

    public function  __call($strName, $arrArguments) {



    }
    public function FinalAction($arrPostData){
        if(is_null($arrPostData)){
            $arrPostData = $_GET;
            //throw new MLCApiException("Cannot auth via GET");
        }
        //Check the post data for email and pass
        if(
            (array_key_exists(MLCAuthQS::email, $arrPostData)) &&
            (array_key_exists(MLCAuthQS::password, $arrPostData))
        ){
            $blnSuccess = MLCAuthDriver::Authenticate(
                $arrPostData[MLCAuthQS::email],
                $arrPostData[MLCAuthQS::password]
            );
            if($blnSuccess){
                $objUser = MLCAuthDriver::User();

                $objSession = MLCAuthDriver::GetActiveSession($objUser);
            }
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
            if(!is_null($objUser)){
                $objSession = MLCAuthDriver::GetActiveSession($objUser);
            }

        }
        return new MLCApiResponse($objSession);
    }

}