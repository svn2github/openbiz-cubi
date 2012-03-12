<?php
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
        $key = md5(uniqid());
        return $key;
    }
}
?>