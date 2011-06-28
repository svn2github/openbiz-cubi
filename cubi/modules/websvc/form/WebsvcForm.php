<?php
class WebSvcForm extends EasyForm 
{ 

   	protected function _doInsert($inputRecord)
   	{
        // gen key
        $key = $this->genKey();
        
        // get secret
        $secret = $this->genSecret();
        
        $inputRecord['api_key'] = $key;
        $inputRecord['secret'] = $secret;

   		parent::_doInsert($inputRecord);
   	}

    protected function genKey()
    {
        // generate api key
        $key = md5(uniqid());
        return $key;
    }
    
    protected function genSecret()
    {
        // generate secret
        $secret = sha1(uniqid());
        return $secret;
    }
}
?>