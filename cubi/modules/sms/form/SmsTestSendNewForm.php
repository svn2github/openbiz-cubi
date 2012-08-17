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
class SmsTestSendNewForm extends EasyForm
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
    public function InsertRecord(){
		$readInput=$this->readInputRecord();
		preg_match('/13\d{9}/',$readInput['mobile'],$mobile);
		if(!$mobile)
		{
			$this->m_Errors = array("test"=>$this->getMessage("MOBILE_ERROR"));
			$this->updateForm();
			return false;
		}
		parent::InsertRecord();
		//触发器的机制没有效果暂用如下代码先实现
		$SmsQueueDO = BizSystem::getObject('sms.do.SmsQueueDO');
		$data=array(
				'tasklist_id'=>$this->getRecordId(),
				'mobile'=>$readInput['mobile'],
				'provider'=>$readInput['provider'],
				'content'=>$readInput['content'],
				'status'=>'pending'
				);
		 $SmsQueueDO->insertRecord($data);	
		return true;
    }    
}  
?>