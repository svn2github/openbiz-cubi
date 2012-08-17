<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: oauthService.php 3371 2012-05-31 06:17:21Z rockyswen@gmail.com $
 */
 include_once(MODULE_PATH."/sms/lib/sms.class.php");
class TaskService 
{
	protected $m_SmsTasklistDO='sms.do.SmsTasklistDO';
	protected $m_SmsQueueDO='sms.do.SmsQueueDO';
	
	public function insertSmsQueue($taskId){
		$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
		$eventlog->log("SMSTRIGGER", "insertSmsQueue", serialize($taskId));
		if(!$taskId)
		{
			return false;
		}
		$TasklistDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$TasklistArr=$TasklistDO->fetchOne('id='.$taskId);
		 if($TasklistArr)
		 {
			$TasklistArr=$TasklistArr->toArray();
		 }
		$data=array(
				'tasklist_id'=>$TasklistArr['Id'],
				'mobile'=>$TasklistArr['mobile'],
				'provider'=>$TasklistArr['provider'],
				'content'=> serialize($taskId),//$TasklistArr['content'],
				'status'=>$TasklistArr['pending']
				);
		$SmsQueueDO->insertRecord($data);
	}
	 
}
?>