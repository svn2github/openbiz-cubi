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
		preg_match('/1\d{10}/',$inputRec['mobile'],$mobile);
		if(!$mobile)
		{
			$this->m_Errors = array("fld_mobile"=>$this->getMessage("MOBILE_ERROR"));
			$this->updateForm();
			return false;
		}
		$providerId = $inputRec['provider'];
		$mobile 	= $inputRec['mobile'];
		$content 	= $inputRec['content'];
		
		//send the message from specified provider directly 
		BizSystem::getService("sms.lib.SmsService")->sendSMS($mobile,$content,0,false,$providerId);
		
		$this->m_Notices = array("test"=>$this->getMessage("SMS_SENT_SUCCESSFUL"));
		$this->updateForm();
    }    
}  
?>