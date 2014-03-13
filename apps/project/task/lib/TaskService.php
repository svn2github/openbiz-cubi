<?php
class TaskService 
{
	protected $m_DataObj = 'project.task.do.TaskListDO';
	
	public function updateTaskFinancial($budgetDO){				
		$task_id = $this->getObjValue($budgetDO, 'foreign_id');
		$type = $this->getObjValue($budgetDO, 'type');		
		$statDO = BizSystem::getObject("project.budget.do.BudgetStatDO");
		$statRec = $statDO->fetchOne("[foreign_id]='$task_id' and [type]='$type'");
		$total_credit = $statRec['total_credit'];		
		$taskRec = BizSystem::getObject($this->m_DataObj)->fetchById($task_id);
		$taskRec['actual_cost'] = $total_credit;		
		$taskRec->save();		
	}
	
	public function updateTaskTime($worklogDO){						
		$task_id = $this->getObjValue($worklogDO, 'task_id');
		if(!$task_id){
			return;
		}
		$statDO = BizSystem::getObject("project.worklog.do.WorkLogStatDO");
		$statRec = $statDO->fetchOne("[task_id]='$task_id'");
		$total_hours = $statRec['total_hours'];
		$taskRec = BizSystem::getObject($this->m_DataObj)->fetchById($task_id);
		$taskRec['actual_workhour'] = $total_hours;
				
		$progress = $taskRec['progress'];
		if($progress==0){
			$taskRec['status']=0;
		
		}
		elseif($progress==100)		
		{
			$taskRec['status']=2;			
		}
		else
		{
			$taskRec['status']=1;			
		}
//		var_dump($progress);
//		var_dump($taskRec['status']);exit;
		$taskRec->save();
//		$taskNoticeDO = $taskRec->getDataObj();
//		$this->notifyUserUpdate($taskNoticeDO);		
	}	
	
	public function updateTaskStatus($taskDO){
		$task_id = (int)$this->getObjValue($taskDO, 'Id');
		if(!$task_id){
			return;
		}
		$progress = $this->getObjValue($taskDO, 'progress');
		
		$status_prev = $taskDO->getField('status')->m_OldValue;
		$status_new = $taskDO->getField('status')->m_Value;	
		
		
		$taskPickDO = BizSystem::getObject($this->m_DataObj);		
		$taskRec = $taskPickDO->fetchById($task_id);
		$update = false;		
		
		

		if($progress==0){
			if($status_new == $status_prev){
				$update = true;
				$taskRec['status']=0;
			}	
		}
		elseif($progress==100)		
		{
			if($status_new == $status_prev){
				$update = true;
				$taskRec['status']=2;
			}
		}
		else
		{
			if((int)$status_prev==4)
			{
				$start_time = $taskDO->getField('start_time')->m_Value;
				if(strtotime($start_time)>time()){
					$update = true;
					$taskRec['status']=0;
				}
			}
			elseif((int)$status_prev!=1)
			{
				$update = true;								
				$taskRec['status']=1;
			}
			
			if($status_prev!=$status_new && $status_new==2){
				$update = true;				
				$taskRec['progress']=100;
			}
		}		
		if($update){
			if($taskRec->getDataObj()->canUpdateRecord($taskRec)){
				$taskRec->save();			
			}
		}		
	}
	
	public function genFinishTime($start_time, $duration)
	{
		if(!is_numeric($start_time))
		{
			$start_time = strtotime($start_time);
		}
		if($duration>=8){
       		$date_add = (int)($duration/8) * 86400; 
       	}
       	$hour_add = fmod($duration,8) * 3600 + 8*3600;
		$finish_time =  	date('Y-m-d H:i:s',($start_time + $date_add + $hour_add)) ;
		return $finish_time; 		
	}
	
	public function getObjValue($obj,$attr)
	{
		if(is_a($obj,"DataRecord"))
		{
			return $obj[$attr];
		}
		$fld_attr = $obj->getField($attr);			
		$value = $fld_attr->m_Value?$fld_attr->m_Value:$fld_attr->m_OldValue;
		if(!$value){								
			$rec = $obj->getActiveRecord();
			$value = $rec[$attr];
		}
		if(!$value)
		{
			if($obj->m_Association['Column'] == $attr){
				$value = $obj->m_Association['FieldRefVal'];
			}
		}
		return $value;
	}
	public function notifyUserUpdate($taskDO){
		$task_id = (int)$this->getObjValue($taskDO, 'Id');				
		$task_id= $task_id?$task_id:$taskDO->getField('Id')->m_Value;
		if(!$task_id){
			return;
		}
		
		$reminder = $taskDO->getField('reminder')->m_Value;
		if(!$reminder)
		{
			return ;
		}
		
		$status_prev = $taskDO->getField('status')->m_OldValue;
		$status_new = $taskDO->getField('status')->m_Value;		

		$progress_prev = $taskDO->getField('progress')->m_OldValue;
		$progress_new = $taskDO->getField('progress')->m_Value;
		
		$creator_id = $taskDO->getField('create_by')->m_Value;
		$owner_id = $taskDO->getField('owner_id')->m_Value;

		if($status_prev == $status_new && $progress_prev == $progress_new){
			//skip notify if nothing important field changes
			return ;
		}
		
		$status_prev = BizSystem::getService(LOV_SERVICE)->getTextByValue("project.task.lov.TaskLOV(TaskStatus)",$status_prev);
		$status_new = BizSystem::getService(LOV_SERVICE)->getTextByValue("project.task.lov.TaskLOV(TaskStatus)",$status_new);				
		
		$data = array(
			"progress_prev" => $progress_prev."%",
			"progress_new" => $progress_new."%",
			"status_prev" => $status_prev,
			"status_new" => $status_new,
			"data_record" => $taskDO->getField('title')->m_Value,
			"app_index" => APP_INDEX,
			"app_url" => APP_URL,
			"operator_name" => BizSystem::GetProfileName(BizSystem::getUserProfile("Id")),
			"action_timestamp"=> date("Y-m-d H:i:s"),
			"refer_url" => SITE_URL
		);				
		
		$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
		$emailSvc->TaskUpdateEmail($creator_id, $data);
	
		//notify owner
		if($owner_id && $creator_id!=$owner_id){
			$emailSvc->TaskUpdateEmail($owner_id, $data);
		}
		
		$group_id = $taskDO->getField('group_id')->m_Value;
		$group_perm = $taskDO->getField('group_perm')->m_Value;
		$other_perm = $taskDO->getField('other_perm')->m_Value;
		
		//test if changes for group level visiable
		if($group_perm>=1)
		{
			$userList = $this->_getGroupUserList($group_id);
			foreach($userList as $user_id)
			{
				$emailSvc->TaskUpdateEmail($user_id, $data);
			}				
		}
		//test if changes for other group level visiable
		if($other_perm>=1)
		{				
			$groupList = $this->_getGroupList();
			foreach($groupList as $group_id){								
				$userList = $this->_getGroupUserList($group_id);
				foreach($userList as $user_id)
				{
					$emailSvc->TaskUpdateEmail($user_id, $data);
				}				
			}
		}
	}
	
	
	protected function _getGroupList(){
		$rs = BizSystem::getObject("system.do.GroupDO")->directFetch("");
		$group_ids = array();
		foreach($rs as $group){
			$group_ids[]=$group['Id'];
		}
		return $group_ids;
	}
	
	protected function _getGroupUserList($group_id){
		$rs = BizSystem::getObject("system.do.UserGroupDO")->directFetch("[group_id]='$group_id'");
		$user_ids = array();
		foreach($rs as $user){
			$user_ids[]=$user['user_id'];
		}
		return $user_ids;
	}	
}