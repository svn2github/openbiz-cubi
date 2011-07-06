<?php
class TaskService 
{
	protected $m_DataObj = 'collab.task.do.TaskListDO';
	
	public function updateTaskFinancial($billingDO){				
		$task_id = $this->getObjValue($billingDO, 'foreign_id');
		$type = $this->getObjValue($billingDO, 'type');		
		$statDO = BizSystem::getObject("collab.billing.do.BillingStatDO");
		$statRec = $statDO->fetchOne("[foreign_id]='$task_id' and [type]='$type'");
		$total_credit = $statRec['total_credit'];
		$taskRec = BizSystem::getObject($this->m_DataObj)->fetchById($task_id);
		$taskRec['actual_cost'] = $total_credit;
		$taskRec->save();		
	}
	
	public function updateTaskTime($worklogDO){						
		$task_id = $this->getObjValue($worklogDO, 'task_id');
		$statDO = BizSystem::getObject("collab.worklog.do.WorkLogStatDO");
		$statRec = $statDO->fetchOne("[task_id]='$task_id'");
		$total_hours = $statRec['total_hours'];
		$taskRec = BizSystem::getObject($this->m_DataObj)->fetchById($task_id);
		$taskRec['actual_workhour'] = $total_hours;
		$taskRec->save();		
	}	
	
	public function updateTaskStatus($taskDO){
		$task_id = $this->getObjValue($taskDO, 'Id');
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
			if((int)$status_prev!=1)
			{
				$update = true;
				$taskRec['status']=1;
			}
		}		
		if($update){
			$taskRec->save();
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
		if(!$task_id){								
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
	
}