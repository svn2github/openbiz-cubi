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
 * @version   $Id: UserPreferenceForm.php 3814 2012-08-05 07:27:06Z rockyswen@gmail.com $
 */

/**
 * UserPreferenceForm class - implement the logic of setting user preferences
 *
 * @access public
 */
class ListForm extends EasyForm
{
	public function getSentMessageCount(){
		 include_once(MODULE_PATH."/sms/lib/sms.class.php");
		 $SmsProviderDO = BizSystem::getObject('sms.provider.do.ProviderDO');
		 $SmsProviderList=$SmsProviderDO->directFetch("[status]=1",10,0,"[priority] DESC");
		 
		 if($SmsProviderList)
		 {
			$SmsProviderList=$SmsProviderList->toArray();
			 foreach($SmsProviderList as $val)
			 { 
				$use_sms_count=Sms::getSentMessageCount($val['type'],$val);
				$SmsProvider=$SmsProviderDO->updateRecords ("use_sms_count=$use_sms_count","Id=".$val['Id']);
				if($SmsProvider && $use_sms_count)
				{
					$this->m_Notices = array("test"=>$this->getMessage("SYNC_SUCCESS"));
				}
				else
				{
					$this->m_Errors = array("test"=>$this->getMessage("SYNC_FAILURE"));	
				}
				
			 }
		 }
		$this->updateForm();
		$this->rerender();
	}  

}  
?>