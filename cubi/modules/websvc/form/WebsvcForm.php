<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.websvc.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

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