<?php
/**
* Class and Function List:
* Function list:
* Classes list:
* - AuthUserSettingTypeCdEditPanel extends AuthUserSettingTypeCdEditPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthUserSettingTypeCdEditPanelBase.class.php");
class AuthUserSettingTypeCdEditPanel extends AuthUserSettingTypeCdEditPanelBase {
    /*
    public function __construct($objParentControl, $objAuthUserSettingTypeCd = null){
    parent::__construct($objParentControl, $objAuthUserSettingTypeCd);
        
            
            
        
            
            
                $this->InitShortDescAutocomplete();
            
        
    }
    public function SetAuthUserSettingTypeCd($objAuthUserSettingTypeCd){
        parent::SetAuthUserSettingTypeCd($objAuthUserSettingTypeCd);
        
        
        
        
            if(
                (!is_null($this->strShortDesc)) &&
                (!is_null($this->objAuthUserSettingTypeCd->shortDesc))
            ){
                
                
                    $this->strShortDesc->Value = $this->strShortDesc->Text;
                
            }
        
        
    }
    public function btnSave_click() {
        if (is_null($this->objAuthUserSettingTypeCd)) {
                //Create a new one
                $this->objAuthUserSettingTypeCd = new AuthUserSettingTypeCd();
        }
        
            
        
            
                if(
                    (!is_null($this->strShortDesc))
                ){
                    
                    
                        $this->strShortDesc->Text = $this->strShortDesc->Value;
                    
                }
            
        
        parent::btnSave_click();
    }
    
    
    
    
    
    
    public function _searchShortDesc($objRoute){
    
    
       $strSearch = $_POST['search'];
       $arrData = array();
       
           $arrAuthUserSettingTypeCds = AuthUserSettingTypeCd::Query(
                sprintf(
                  'WHERE ShortDesc LIKE "%s%%"',
                  strtolower($strSearch)
              )
           );
           foreach($arrAuthUserSettingTypeCds as $strKey => $objAuthUserSettingTypeCd){
               $arrData[$strKey] = array(
                      'value'=>$objAuthUserSettingTypeCd->ShortDesc,
                      'text'=>$objAuthUserSettingTypeCd->ShortDesc
               );
           }
           if(count($arrData) == 0){
                $arrData[] = array(
                    'value'=> $strSearch,
                    'text'=> $strSearch
                );
           }
       
       
       die(
           json_encode(
               $arrData
           )
       );
    }
    
    
    */
}
?>