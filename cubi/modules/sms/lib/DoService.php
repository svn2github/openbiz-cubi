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
 * @version   $Id: TaskService.php 3371 2012-08-30 06:17:21Z fsliit@gmail.com $
 */
 
class DoService 
{
	protected $m_SmsTasklistDO='sms.task.do.TaskDO';
	protected $m_SmsQueueDO='sms.queue.do.QueueDO';
	protected $m_SmsLogDO='sms.log.do.LogDO';
	public function insertSmsQueue($taskId){
		if(!$taskId)
		{
			return false;
		}
		$RecrdArr=$taskId->getActiveRecord();
		$TasklistDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$TasklistArr=$TasklistDO->fetchOne('[Id]='.$RecrdArr['Id']);
		 if($TasklistArr)
		 {
			$TasklistArr=$TasklistArr->toArray();
		 }
		$data=array(
				'tasklist_id'=>$TasklistArr['Id'],
				'mobile'=>$TasklistArr['mobile'],
				'provider'=>$TasklistArr['provider'],
				'content'=> $TasklistArr['content'],
				'status'=>$TasklistArr['status']
				);
		$SmsQueueDO->insertRecord($data);
	}
	public function insertSmsLog($id){
		if(!$id)
		{
			return false;
		}
		$RecrdArr=$id->getActiveRecord();
		$SmsLogDO = BizSystem::getObject($this->m_SmsLogDO);
		$data=array(
				'tasklist_id'=>$RecrdArr['tasklist_id'],
				'queue_id'=>$RecrdArr['Id'],
				'mobile'=>$RecrdArr['mobile'],
				'provider'=>$RecrdArr['provider'],
				'content'=> $RecrdArr['content'],
				'status'=>$RecrdArr['status']
				);
		$SmsLogDO->insertRecord($data);
	}
}
?>