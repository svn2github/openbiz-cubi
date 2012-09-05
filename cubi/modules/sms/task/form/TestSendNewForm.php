<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.system.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: TestSendNewForm.php 3814 2012-08-30  fsliit@gmail.com $
 */
 
class TestSendNewForm extends EasyForm
{
    public function InsertRecord(){
		$inputRec=$this->readInputRecord();
		$SmsObj=BizSystem::getService("sms.lib.SmsService");
		if(!$SmsObj->validateMobile($inputRec['mobile']))
		{
			$this->m_Errors = array("fld_mobile"=>$this->getMessage("MOBILE_ERROR"));
			$this->updateForm();
			return false;
		}
		
		$provider 	= $inputRec['provider'];
		$mobile 	= $inputRec['mobile'];
		$content 	= $inputRec['content'];
		$queue		= $inputRec['queue'];
		//send the message from specified provider directly 
		$rec=$SmsObj->sendSMS($mobile,$content,0,$queue,$provider);
		if($rec)
		{
			$this->m_Notices = array("test"=>$this->getMessage("SMS_SENT_SUCCESSFUL"));
		}
		else
		{
			$this->m_Errors = array("test"=>$this->getMessage("SMS_SENT_FAILURE"));
		}
		
		$this->updateForm();
    }    
}  
?>