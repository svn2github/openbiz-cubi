<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.license.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LicActCodeForm.php 3361 2012-05-31 06:01:42Z rockyswen@gmail.com $
 */

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