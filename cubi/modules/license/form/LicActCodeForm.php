<?php
include_once MODULE_PATH."/license/lib/alphaID.inc.php";

class LicActCodeForm extends EasyForm 
{ 

   	protected function _doInsert($inputRecord)
   	{
        // gen key
        $key = $this->genKey();
        
        $inputRecord['activation_code'] = $key;

   		parent::_doInsert($inputRecord);
   	}

    protected function genKey()
    {
        // generate api key
        //$key = md5(uniqid());
		$key = alphaID(time());
        return $key;
    }
}

?>