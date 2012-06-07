<?php 
require_once "AssetForm.php";
class AssetQueryForm extends AssetForm
{
	public function QueryBarcode()
	{
		
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        $barcode = $recArr['barcode'];
        

         $rec = $this->getDataObj()->fetchOne("[barcode]='$barcode'");
         if(!$rec){
         	$errorMsg = array(
         		"fld_barcode" => $this->getMessage("BARCODE_NOT_FOUND")
         	);
            $this->processFormObjError($errorMsg);
            return;            	
         }
         else
         {
         	$recId = $rec["Id"];
         	$redirectPage = APP_INDEX."/asset/asset_detail/".$recId;
         	BizSystem::clientProxy()->ReDirectPage($redirectPage);
         }
                                
        return;

    }
}

?>