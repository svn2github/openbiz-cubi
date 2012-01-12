<?php 
class ReminderService
{
	/**
	 * Main Entry function
	 * It will check and reminder task and event, 
	 * also sends notification email to event related contacts
	 */
	public function CheckRemind()
	{
		$this->CheckRemidforTask();
		$this->CheckRemidforEvent();
		$this->CheckNotifyforEvent();
		return;
	}
	
	/**
	 * 
	 * It will check all not start tasks
	 * and find out reminder is equal to 1 (enabled), 
	 * and reminder_status equal to 0 (not notified)
	 * and task_expected_start_time - reminder_time(mins) < current time
	 * then trigger email notice feature
	 */
	protected function CheckRemidforTask(){
		/**
		 * find out which task should be remind to users
		 * select Now(), DATE_ADD(NOW(), INTERVAL -15 MINUTE)
		 */
		$taskDO = BizSystem::getObject("collab.task.do.TaskSystemDO",1);
		$searchRule = "(
						    [reminder_status]=0 
						AND [reminder]=1 
						AND [status] = 0 
						AND DATE_ADD([start_time], INTERVAL -[reminder_time] MINUTE)< NOW()
						)";
		
		$taskList = $taskDO->directFetch($searchRule);
		$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
		foreach ($taskList as $taskRec)
		{
			/**
			 * do remind uesrs
			 */
			$userList = BizSystem::getService(DATAPERM_SERVICE)->getReadableUserList($taskRec);
			foreach ($userList as $user_id)
			{
				$emailSvc->SendEmailToUser("TaskRemindEmail",$user_id,$taskRec);
			}
			
			/**
			 * mark the task is reminded, set reminder_status equal to 1
			 * [Id]='".$taskRec['Id']."'   comes from [Id]='2'
			 */
			$taskDO->updateRecords("[reminder_status]=1", "[Id]='".$taskRec['Id']."'");
		}
	}
	

	
	protected function CheckRemidforEvent(){
		
	}
	
	protected function CheckNotifyforEvent(){
		
	}	
}
?>