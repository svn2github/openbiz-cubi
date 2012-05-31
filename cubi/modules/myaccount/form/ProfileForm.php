<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.myaccount.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once(MODULE_PATH."/contact/form/ContactForm.php");

class ProfileForm extends ContactForm
{
	
	
    public function allowAccess(){
    	parent::allowAccess();

    	if(BizSystem::getUserProfile("Id"))
    	{
  	 		return 1;
    	}
    	else
    	{
    		return 0;
    	}
    }
	
	public function fetchData(){
		$svcobj = BizSystem::getService(PROFILE_SERVICE);
		//echo BizSystem::getUserProfile("profile_Id");
		//echo $svcobj->checkExist(BizSystem::getUserProfile("profile_Id"));
		if(!BizSystem::getUserProfile("profile_Id") || !$svcobj->checkExist(BizSystem::getUserProfile("profile_Id")) ){			
			$profile_id = $svcobj->CreateProfile();
			$svcobj->InitProfile(BizSystem::getUserProfile("username"));
			$this->updateForm();
		}
		return parent::fetchData();
	}
	
}
?>
