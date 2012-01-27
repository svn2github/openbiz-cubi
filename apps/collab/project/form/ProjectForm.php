<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class ProjectForm extends ChangeLogForm
{
	public function UpdateProjectStatus($id, $fld_name, $value)
	{
		if($value == 1){
    		$value_xor = 2;  		
    	}else{
    		$value_xor = 1;
    	}    	
		return $this->updateFieldValue($id,$fld_name,$value_xor);		
	}
	
	public function fetchDataSet(){
		$result = parent::fetchDataSet();
		if(!$this->m_RecordId){
			$this->m_RecordId = $result[0]['Id'];
		}
		return $result;
	}
	
	public function fetchData()
	{
		$result = parent::fetchData();
	
		$result['budget_spend'] = $this->getProjectSpent($result["Id"]);
		if($result['budget_cost']){
			$result['cost_spend_bar'] = sprintf("%.2f",($result['budget_spend']/$result['budget_cost'])*100);
		}else{
			if($result['budget_spend']){
				$result['cost_spend_bar'] = 100;
			}else{
				$result['cost_spend_bar'] = 0;
			}
		}
		
		return $result;
	}
	
	public function getProjectSpent($project_id)
	{
		if(!$project_id)
		{
			return "0";
		}
		$total_spend=0;
		$taskList = BizSystem::getObject("collab.task.do.TaskSystemDO")->directfetch("[project_id]='$project_id'");
		foreach ($taskList as $task)
		{
			$total_spend += $this->getTaskSpent($task["Id"]);		
		}
		return (float)$total_spend;
	}
	
	public function getTaskSpent($task_id)
	{
		if(!$task_id)
		{
			return "0";
		}
		$result = BizSystem::getObject("collab.task.do.TaskBudgetDO")->fetchOne("[task_id]='$task_id'");
		if($result)
		{
			return $result['total_credit'];
		}
		else
		{
			return "0";	
		}
	}	
}
?>
