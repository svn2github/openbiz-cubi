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
		/**
		 * find out which task should be remind to users
		 * select Now(), DATE_ADD(NOW(), INTERVAL -15 MINUTE)
		 */
		$taskDO = BizSystem::getObject("collab.calendar.do.EventSystemDO",1);
		$searchRule = "(
						    [reminder_status]=0 
						AND [reminder]=1 
						AND (DATE_ADD([start_time], INTERVAL -[reminder_time] MINUTE)< NOW() OR [recurrence]>0 )
						)";
		
		$taskList = $taskDO->directFetch($searchRule);
		$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
		foreach ($taskList as $taskRec)
		{
			/**
			 * do remind uesrs
			 */
			if($taskRec['recurrence']==0){
				$userList = BizSystem::getService(DATAPERM_SERVICE)->getReadableUserList($taskRec);
				foreach ($userList as $user_id)
				{
					$emailSvc->SendEmailToUser("EventRemindEmail",$user_id,$taskRec);
				}
				
				/**
				 * mark the task is reminded, set reminder_status equal to 1
				 * [Id]='".$taskRec['Id']."'   comes from [Id]='2'
				 */
				$taskDO->updateRecords("[reminder_status]=1", "[Id]='".$taskRec['Id']."'");
			}	
		
			if($taskRec['recurrence']>0){
				if($this->_isNeedRemind($taskRec))
				{
					$userList = BizSystem::getService(DATAPERM_SERVICE)->getReadableUserList($taskRec);
					foreach ($userList as $user_id)
					{
						$emailSvc->SendEmailToUser("EventRemindEmail",$user_id,$taskRec);
					}
					$taskDO->updateRecords("[reminder_lasttime]=NOW()", "[Id]='".$taskRec['Id']."'");
				}
			}
		
		}
				
	}
	
	
	
	protected function CheckNotifyforEvent(){
		$taskDO = BizSystem::getObject("collab.calendar.do.EventSystemDO",1);
		$searchRule = "(
						    [notify_contacts_status]=0 
						AND [notify_contacts]=1 
						AND (DATE_ADD([start_time], INTERVAL -[notify_contacts_time] MINUTE)< NOW() OR [recurrence]>0 )
						)";
		
		$taskList = $taskDO->directFetch($searchRule);
		$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
		foreach ($taskList as $taskRec)
		{
			/**
			 * do remind contacts
			 */
			if($taskRec['recurrence']==0){
				$contactList = BizSystem::getObject("collab.calendar.do.EventContactDO")->directFetch("[event_id]='".$taskRec['Id']."'");
				foreach ($contactList as $contactRec)
				{
					$contact_id = $contactRec['contact_id'];
					$emailSvc->SendEmailToContact("EventNoticeEmail",$contact_id,$taskRec);
				}
				
				/**
				 * mark the task is reminded, set reminder_status equal to 1
				 * [Id]='".$taskRec['Id']."'   comes from [Id]='2'
				 */
				$taskDO->updateRecords("[notify_contacts_status]=1", "[Id]='".$taskRec['Id']."'");
			}	
		
			if($taskRec['recurrence']>0){
				if($this->_isNeedNotify($taskRec))
				{
					$contactList = BizSystem::getObject("collab.calendar.do.EventContactDO")->directFetch("[event_id]='".$taskRec['Id']."'");
					foreach ($contactList as $contactRec)
					{
						$contact_id = $contactRec['contact_id'];
						$emailSvc->SendEmailToContact("EventRemindEmail",$contact_id,$taskRec);
					}
					$taskDO->updateRecords("[notify_contacts_lasttime]=NOW()", "[Id]='".$taskRec['Id']."'");
				}
			}
		
		}
		
	}
	
	private function _isNeedRemind($taskRec)
	{
		$nextTaskRec = $this->_getNextRepeatTime($taskRec);
		$repeatPeriod = $this->_getRepeatPeriodSecond($taskRec);
		if(strtotime($nextTaskRec['start_time'])-$nextTaskRec['reminder_time']*60 < time()){
			if(time() - strtotime($nextTaskRec['reminder_lasttime']) > $repeatPeriod ){
				return true;
			}
		}
		return false;
	}
	
	private function _isNeedNotify($taskRec)
	{
		$nextTaskRec = $this->_getNextRepeatTime($taskRec);
		$repeatPeriod = $this->_getRepeatPeriodSecond($taskRec);
		if(strtotime($nextTaskRec['start_time'])-$nextTaskRec['notify_contacts_time']*60 < time()){
			if(time() - strtotime($nextTaskRec['notify_contacts_lasttime']) > $repeatPeriod ){
				return true;
			}
		}
		return false;
	}
	
	private function _getRepeatPeriodSecond($record)
	{
		switch($record['recurrence'])
		{
			case "1":	
				$period =  86400;
				break;
			case "2":	
				$period =  86400*7;
				break;
			case "3":	
				$period =  86400*30;
				break;
			case "4":	
				$period =  86400*365;
				break;
		}
		return $period;
	}

	private function _getNextRepeatTime($record)
	{
		/**
		 *    
		   <RecurrenceType Value="0" text="None"/>
		   <RecurrenceType Value="1" text="Daily"/>
		   <RecurrenceType Value="2" text="Weekly"/>
		   <RecurrenceType Value="3" text="Monthly"/>
		   <RecurrenceType Value="4" text="Annually"/>         
		 */
		$records = array();
		$i=1;
		switch($record['recurrence'])
		{
			case "1":				
				$rec = $record;
				$new_start_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d")." ".date("H:i:s",strtotime($record['start_time'])))+86400*$i);
				$new_end_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d")." ".date("H:i:s",strtotime($record['end_time'])))+86400*$i);															
				$rec['start_time'] = $new_start_time;
				$rec['end_time'] = $new_end_time;
				$records[strtotime($rec['start_time'])]=$rec;									
				break;
				
			case "2":				
				$rec = $record;
				$new_start_time = strtotime($record['start_time']);		
				$weekday_org = date('w',$new_start_time);
				$weekday_cur = date('w');			
				$weekday_diff = $weekday_org - $weekday_cur ;					
				$dayinthisweek = time() + $weekday_diff*86400 + 7*86400*$i;													
				$rec['start_time'] = date("Y-m-d",$dayinthisweek)." ".date("H:i:s",strtotime($record['start_time']));					
		    	
				$new_end_time = strtotime($record['end_time']);		
				$weekday_org = date('w',$new_end_time);
				$weekday_cur = date('w');			
				$weekday_diff = $weekday_org - $weekday_cur ;					
				$dayinthisweek = time() + $weekday_diff*86400 + 7*86400*$i;													
				$rec['end_time'] = date("Y-m-d",$dayinthisweek)." ".date("H:i:s",strtotime($record['end_time']));;
				
				
				$records[strtotime($rec['start_time'])]=$rec;					
				
				break;
				
			case "3":
				$rec = $record;
				$new_start_time = strtotime($record['start_time']);					
				if(date('m',$new_start_time)+$i>12){
					$month = date('m',$new_start_time)+$i - 12;
					$offset_y = 1;
				}else{
					$month = date('m',$new_start_time)+$i;
					$offset_y = 0;
				}					
				$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_start_time),
		      	date('i',$new_start_time), date('s',$new_start_time), $month,
		    	date('d',$new_start_time), date('Y')+$offset_y ));
				$rec['start_time'] = $newdate;					
		    	
				$new_end_time = strtotime($record['end_time']);
				if(date('m',$new_end_time)+$i>12){
					$month = date('m',$new_end_time)+$i - 12;
					$offset_y = 1;
				}else{
					$month = date('m',$new_end_time)+$i;
					$offset_y = 0;
				}					
				$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_end_time),
		      	date('i',$new_end_time), date('s',$new_end_time), $month,
		    	date('d',$new_end_time), date('Y')+$offset_y ));      										
				$rec['end_time'] = $newdate;
				
				$records[strtotime($rec['start_time'])]=$rec;					
				
				break;
				
			case "4":				
				$rec = $record;
				$new_start_time = strtotime($record['start_time']);					
		      	$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_start_time),
		      	date('i',$new_start_time), date('s',$new_start_time), date('m',$new_start_time),
		    	date('d',$new_start_time), date('Y')+$i));      										
				$rec['start_time'] = $newdate;
									
				$new_end_time = strtotime($record['end_time']);
				$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_end_time),
		      	date('i',$new_end_time), date('s',$new_end_time), date('m',$new_end_time),
		    	date('d',$new_end_time), date('Y')+$i));      										
				$rec['end_time'] = $newdate;
				
				$records[strtotime($rec['start_time'])]=$rec;					
				
				break;
		}
		return $records;
	}
}
?>