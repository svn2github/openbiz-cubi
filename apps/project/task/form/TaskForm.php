<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class TaskForm extends ChangeLogForm
{		
	public $m_parent_task_desc ;
	public $m_dependency_task_desc ;  
	
	protected function _doInsert($inputRecord)	
	{		
		$recurrence = $inputRecord['recurrence'];
		$recurrence_times = $inputRecord['recurrence_times'];		
		
		if(!$recurrence_times)
		{
			$recurrence_times = 1;
		}
		
		unset($inputRecord['recurrence']);
		unset($inputRecord['recurrence_times']);
		
		switch ($recurrence)
		{
			default:
			case "0":
				$recId = parent::_doInsert($inputRecord);
				break;
			case "1": //daily				
			case "2": //weekly			
			case "3": //monthly			
			case "4": //anual
				$org_title = $inputRecord['title'];
				$org_start_time = $inputRecord['start_time'];
				$org_finish_time = $inputRecord['finish_time'];
				$recIds = array();
				for($i=$recurrence_times;$i>=1;$i--){
					$inputRecord['title']		= $org_title.'-'.$i;
					$inputRecord['start_time']	= $this->getRecurrenceTime($org_start_time, $recurrence, $i-1);
					$inputRecord['finish_time']	= $this->getRecurrenceTime($org_finish_time, $recurrence, $i-1);
					
					$recId = parent::_doInsert($inputRecord);
				}
				break;
		}
		return $recId;
	}
	
	public function getRecurrenceTime($timestamp,$recurrence_type,$recurrence_times)
	{		
	
		switch($recurrence_type)
		{
			case "1":
				$i=$recurrence_times;				
				$new_time = date("Y-m-d H:i:s",strtotime($timestamp)+86400*$i);				
				break;
				
			case "2":
				$i=$recurrence_times;
				$new_time = strtotime($timestamp);		
				$weekday_org = date('w',$new_time);
				$weekday_cur = date('w');			
				$weekday_diff = $weekday_org - $weekday_cur ;					
				$dayinthisweek = time() + $weekday_diff*86400 + 7*86400*$i;													
				$new_time = date("Y-m-d",$dayinthisweek)." ".date("H:i:s",strtotime($timestamp));					
			    break;
			    
			case "3":
				$i=$recurrence_times;				
				$new_time = strtotime($timestamp);					
				if(date('m',$new_time)+$i>12){
					$month = date('m',$new_time)+$i - 12;
					$offset_y = 1;
				}else{
					$month = date('m',$new_time)+$i;
					$offset_y = 0;
				}					
				$new_time = date('Y-m-d h:i:s', mktime(date('h',$new_time),
		      	date('i',$new_time), date('s',$new_time), $month,
		    	date('d',$new_time), date('Y')+$offset_y )); 		    										
				break;
				
			case "4":
				$i=$recurrence_times;
				$new_time = date("Y-m-d H:i:s",strtotime($timestamp)+86400*365*$i);  										
				break;
		}
		
		return $new_time;
	}	
	
	public function UpdateTaskStatus($id, $fld_name, $value)
	{
		if($value == 1){
    		$value_xor = 2;
	        $currentRec = $this->getActiveRecord($Id);
      		$recArr = $this->getActiveRecord($Id);
			$recArr["progress"]="100";
        	$this->_doUpdate($recArr, $currentRec);     		
    	}else{
    		$value_xor = 1;
    		$currentRec = $this->getActiveRecord($Id);      		
			if($currentRec["progress"]=="100"){
				$recArr = $this->getActiveRecord($Id);
				$recArr["progress"]="90";
        		$this->_doUpdate($recArr, $currentRec);
			} 
    	}    	
		return $this->updateFieldValue($id,$fld_name,$value_xor);		
	}
	
	public function fetchData(){
		$result = parent::fetchData();
		if($result['total_workhour']>0){
			$result['time_bar'] = sprintf('%.2f',($result['actual_workhour']/$result['total_workhour'])*100);
		}else{
			if($result['actual_workhour']){
				$result['time_bar'] = 100;	
			}else{
				$result['time_bar'] = 0;
			}
		}
		 
		if($result['budget_cost']>0){
			$result['cost_spend_bar'] = sprintf('%.2f',($result['actual_cost']/$result['budget_cost'])*100);
		}else{
			if($result['actual_cost']){
				$result['cost_spend_bar'] = 100;
			}else{
				$result['cost_spend_bar'] = 0;
			}	
		}
		 
		$recArr = $this->readInputRecord();
		
		$svcObj = BizSystem::getObject("project.task.lib.TaskService");
		$do = BizSystem::getObject("project.task.do.TaskListDO");		
		$parent_task_id = $recArr['parent_task_id']?$recArr['parent_task_id']:$result['parent_task_id'];
		if($parent_task_id)
		{
			$taskRec = $do->fetchById($parent_task_id);
			$params = array(
				date('Y/m/d',strtotime($taskRec['start_time'])),
				date('Y/m/d',strtotime($svcObj->genFinishTime($taskRec['start_time'],$taskRec['total_workhour']))),
				$taskRec['total_workhour']
			);
			$this->m_parent_task_desc = $this->getMessage("TASK_DESCRIPTION",$params);
		}		
	
		$dependency_task_id = $recArr['dependency_task_id']?$recArr['dependency_task_id']:$result['dependency_task_id'];
		if($dependency_task_id)
		{
			$taskRec = $do->fetchById($dependency_task_id);
			
			$params = array(
				date('Y/m/d',strtotime($taskRec['start_time'])),
				date('Y/m/d',strtotime($svcObj->genFinishTime($taskRec['start_time'],$taskRec['total_workhour']))),
				$taskRec['total_workhour']
			);
			$this->m_dependency_task_desc = $this->getMessage("TASK_DESCRIPTION",$params);
		}
		
		
		return $result;
	}
	
	public function ValidateForm($cleanErrors = true){
		$result = parent::validateForm($cleanErrors);
		//validate dependecy task and parent task
		$recArr = $this->readInputRecord();
		$do = BizSystem::getObject("project.task.do.TaskListDO");
		$svcObj = BizSystem::getObject("project.task.lib.TaskService");
		
		if($recArr['parent_task_id'])
		{
			$parentTaskRec = $do->fetchById((int)$recArr['parent_task_id']);			 
		}
		
		if($recArr['dependency_task_id'])
		{
			$dependencyTaskRec = $do->fetchById((int)$recArr['dependency_task_id']);			 
		}
		
		if($recArr['dependency_task_id'] && $recArr['parent_task_id'])
		{
			if($recArr['dependency_task_id'] == $recArr['parent_task_id'])
			{
				$this->m_ValidateErrors["fld_dependency"] = $this->getMessage("TASK_PARENT_DEPENDENCY_CAN_NOT_BE_SAME");
				$this->setActiveRecord($recArr);
				throw new ValidationException($this->m_ValidateErrors);
				return false;
			}
			
			//start_time checking
			
			$parent_finish_time = $svcObj->genFinishTime($parentTaskRec['start_time'],$parentTaskRec['total_workhour']);
			
			$dependency_finish_time = $svcObj->genFinishTime($dependencyTaskRec['start_time'],$dependencyTaskRec['total_workhour']);
			
			if(strtotime($dependency_finish_time)>strtotime($parent_finish_time))
			{
				$this->m_ValidateErrors["fld_dependency"] = $this->getMessage("TASK_DEPENDENCY_FINISH_TOO_LATE");
				$this->setActiveRecord($recArr);
				throw new ValidationException($this->m_ValidateErrors);
				return false;
			}
			
		}
		
		//if has start_time then validate its min and max value
		$start_time_min_arr = array();
		$start_time_max_arr = array();
		if($recArr['parent_task_id'])
		{
			$start_time_min_arr[] = strtotime($parentTaskRec['start_time']);
			$start_time_max_arr[] = strtotime($svcObj->genFinishTime($parentTaskRec['start_time'],$parentTaskRec['total_workhour']));
		}
		if($recArr['dependency_task_id'])
		{
			//logic error
			//$start_time_min_arr[] = strtotime($svcObj->genFinishTime($dependencyTaskRec['start_time'],$dependencyTaskRec['total_workhour']));
			//$start_time_max_arr[] = strtotime($dependencyTaskRec['finish_time']);
			$start_time_min_arr[] = strtotime($dependencyTaskRec['finish_time']);
			$start_time_max_arr[] = time()+86400*365*100;
		}
		rsort($start_time_min_arr, SORT_NUMERIC);
		$start_time_min =  $start_time_min_arr[0];
		
		rsort($start_time_max_arr, SORT_NUMERIC);
		$start_time_max =  $start_time_max_arr[0];
		if($recArr['start_time'])
		{
			$start_time = strtotime($recArr['start_time']);
			
				if($start_time_min!=$start_time_max){
					if($start_time < $start_time_min || $start_time> $start_time_max)
					{
						$params = array(
							date('Y/m/d H:i:s',$start_time_min),
							date('Y/m/d H:i:s',$start_time_max)
						);
						$this->m_ValidateErrors["fld_start_time"] = $this->getMessage("TASK_START_TIME_SHOULD_BE_IN",$params);
						$this->setActiveRecord($recArr);
						throw new ValidationException($this->m_ValidateErrors);
						return false;
					}
				}else{
					if($start_time < $start_time_min)
					{
						$params = array(
							date('Y/m/d H:i:s',$start_time_min)						
						);
						$this->m_ValidateErrors["fld_start_time"] = $this->getMessage("TASK_START_TIME_SHOULD_BE_LATER_THAN",$params);
						$this->setActiveRecord($recArr);
						throw new ValidationException($this->m_ValidateErrors);
						return false;
					}
				}
				
			 
		}
		
		
		//if has time_budget then validate its min and max value
		if($recArr['parent_task_id'])
		{
			$parent_finish_time = $svcObj->genFinishTime($parentTaskRec['start_time'],$parentTaskRec['total_workhour']);
			$this_finish_time = $svcObj->genFinishTime($recArr['start_time'],$recArr['total_workhour']);
			if(strtotime($this_finish_time) > strtotime($parent_finish_time))
			{
					$params = array(
						date('Y/m/d H:i:s',strtotime($parent_finish_time))						
					);
					$this->m_ValidateErrors["fld_finish_time"] = $this->getMessage("TASK_FINISH_TIME_SHOULD_BE_EARLIER_THAN",$params);
					//$this->m_ValidateErrors["fld_workhours"] = $this->getMessage("TASK_TIME_BUDGET_SHOULD_BE_DECRASED",$params);
					$this->setActiveRecord($recArr);
					throw new ValidationException($this->m_ValidateErrors);
					return false;				
			}
		}
		
		
		return $result;
	}
	
	public function fetchDataSet()
	{		
		$resultSet = parent::fetchDataSet();
		$recordSet = array();		
		foreach ($resultSet as $record)
		{
			if(date("Y-m-d",strtotime($record['start_time']))==date("Y-m-d")){
				$record['start_time_display_short'] = date("H:i",strtotime($record['start_time']));
			}else{
				$record['start_time_display_short'] = date("Y/m/d",strtotime($record['start_time']));	
			}						
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}  
}
?>