<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.contact.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class ContactGrabberForm extends EasyForm
{
	public function FetchContact()
	{
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

       
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
	
        $provider = $recArr['provider'];
        $username = $recArr['username'];
        $password = $recArr['password'];
        $credential = array(
        	"username"=>$username,
        	"password"=>$password
        );
        
        $contactSvc = BizSystem::getObject("contact.lib.ContactGrabberService");
        try{
	        if(!$contactSvc->ValidateCredential($recArr,$provider)){	        	
	        	$credential_invaild = BizSystem::getService($provider)->getValidateError();
	        	$this->processFormObjError($credential_invaild);
	            return;
	        }
        }
        catch (Exception $e)
        {
        	$credential_invaild = BizSystem::getService($provider)->getValidateError();
        	$this->processFormObjError($credential_invaild);
            return;
        }
        $contacts = $contactSvc->fetchContacts($credential,$provider);        
        //save contacts to import db
        $contactImportDO = BizSystem::GetObject("contact.do.ContactImportDO");                
        $user_id = BizSystem::GetUserProfile("Id");
        
        $contactImportDO->deleteRecords("[user_id]='$user_id'");
        if(is_array($contacts)){
	        foreach ($contacts as $contactRec)
	        {
	        	$contactRec['user_id'] = $user_id;
	        	$contactImportDO->insertRecord($contactRec);
	        }
        }
        $this->switchForm("contact.form.ContactGrabberListForm");
	}
}
?>