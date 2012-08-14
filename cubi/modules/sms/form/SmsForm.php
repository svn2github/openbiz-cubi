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
class SmsForm extends EasyForm
{
	public function getSentMessageCount(){
		 include_once(MODULE_PATH."/sms/lib/sms.class.php");
		 $SmsProviderDO = BizSystem::getObject('sms.do.SmsProviderDO');
		 $SmsProviderList=$SmsProviderDO->directFetch("status=1",10,0,"priority desc");
		 
		 if($SmsProviderList)
		 {
			$SmsProviderList=$SmsProviderList->toArray();
			 foreach($SmsProviderList as $val)
			 { 
				$sms=new Sms( $val['type']);
				$use_sms_count=$sms->getSentMessageCount();
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
    public function InsertRecord(){
		$TasklistDO = BizSystem::getObject('sms.do.SmsTasklistDO');
		$SmsQueueDO = BizSystem::getObject('sms.do.SmsQueueDO');
		$TasklistArr=$TasklistDO->fetchOne('id=1');
		 if($TasklistArr)
		 {
			$TasklistArr=$TasklistArr->toArray();
		 }
		$data=array(
				'tasklist_id'=>$TasklistArr['Id'],
				'mobile'=>$TasklistArr['mobile'],
				'provider'=>$TasklistArr['provider'],
				'content'=>$TasklistArr['content'],
				'status'=>'pending'
				);
		$SmsQueueDO->insertRecord($data);		
		$readInput=$this->readInputRecord();
		preg_match('/13\d{9}/',$readInput['mobile'],$mobile);
		if(!$mobile)
		{
			$this->m_Errors = array("test"=>$this->getMessage("mobile_ERROR"));
			$this->updateForm();
			return false;
		}
		return parent::InsertRecord();
    }    
}  
?>