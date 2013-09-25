<?php
/**
* Class and Function List:
* Function list:
* Classes list:
* - AuthUserTypeCdEditPanel extends AuthUserTypeCdEditPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthUserTypeCdEditPanelBase.class.php");
class AuthUserTypeCdEditPanel extends AuthUserTypeCdEditPanelBase {
    /*
    public function __construct($objParentControl, $objAuthUserTypeCd = null){
    parent::__construct($objParentControl, $objAuthUserTypeCd);
        
            
            
        
            
            
                $this->InitShortDescAutocomplete();
            
        
    }
    public function SetAuthUserTypeCd($objAuthUserTypeCd){
        parent::SetAuthUserTypeCd($objAuthUserTypeCd);
        
        
        
        
            if(
                (!is_null($this->strShortDesc)) &&
                (!is_null($this->objAuthUserTypeCd->shortDesc))
            ){
                
                
                    $this->strShortDesc->Value = $this->strShortDesc->Text;
                
            }
        
        
    }
    public function btnSave_click() {
        if (is_null($this->objAuthUserTypeCd)) {
                //Create a new one
                $this->objAuthUserTypeCd = new AuthUserTypeCd();
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
       
           $arrAuthUserTypeCds = AuthUserTypeCd::Query(
                sprintf(
                  'WHERE ShortDesc LIKE "%s%%"',
                  strtolower($strSearch)
              )
           );
           foreach($arrAuthUserTypeCds as $strKey => $objAuthUserTypeCd){
               $arrData[$strKey] = array(
                      'value'=>$objAuthUserTypeCd->ShortDesc,
                      'text'=>$objAuthUserTypeCd->ShortDesc
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