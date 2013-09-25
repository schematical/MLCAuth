<?php
/**
* Class and Function List:
* Function list:
* Classes list:
* - AuthAccountTypeCdEditPanel extends AuthAccountTypeCdEditPanelBase
*/
require_once (__MODEL_APP_CONTROL__ . "/base_classes/AuthAccountTypeCdEditPanelBase.class.php");
class AuthAccountTypeCdEditPanel extends AuthAccountTypeCdEditPanelBase {
    /*
    public function __construct($objParentControl, $objAuthAccountTypeCd = null){
    parent::__construct($objParentControl, $objAuthAccountTypeCd);
        
            
            
        
            
            
                $this->InitShortDescAutocomplete();
            
        
    }
    public function SetAuthAccountTypeCd($objAuthAccountTypeCd){
        parent::SetAuthAccountTypeCd($objAuthAccountTypeCd);
        
        
        
        
            if(
                (!is_null($this->strShortDesc)) &&
                (!is_null($this->objAuthAccountTypeCd->shortDesc))
            ){
                
                
                    $this->strShortDesc->Value = $this->strShortDesc->Text;
                
            }
        
        
    }
    public function btnSave_click() {
        if (is_null($this->objAuthAccountTypeCd)) {
                //Create a new one
                $this->objAuthAccountTypeCd = new AuthAccountTypeCd();
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
       
           $arrAuthAccountTypeCds = AuthAccountTypeCd::Query(
                sprintf(
                  'WHERE ShortDesc LIKE "%s%%"',
                  strtolower($strSearch)
              )
           );
           foreach($arrAuthAccountTypeCds as $strKey => $objAuthAccountTypeCd){
               $arrData[$strKey] = array(
                      'value'=>$objAuthAccountTypeCd->ShortDesc,
                      'text'=>$objAuthAccountTypeCd->ShortDesc
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