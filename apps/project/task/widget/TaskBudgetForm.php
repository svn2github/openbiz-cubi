<?php 
class TaskBudgetForm extends PickerForm
{
	public function fetchDataSet()
	{
		$result = parent::fetchDataSet();
		$resultNew = array();
		foreach ($result as $task)
		{
			$task['budget_spend'] = $this->getTaskSpent($task["Id"]);
			if($task['budget_cost']){
				$task['budget_precent'] = sprintf("%.2f",($task['budget_spend']/$task['budget_cost'])*100);
			}else{
				if($task['budget_spend']){
					$task['budget_precent'] = 100;
				}else{
					$task['budget_precent'] = 0;
				}
			}
			$resultNew[] = $task;
		}
		return $resultNew;	
	}
	
	public function getTaskSpent($task_id)
	{
		if(!$task_id)
		{
			return "0";
		}
		$result = BizSystem::getObject("project.task.do.TaskBudgetDO")->fetchOne("[task_id]='$task_id'");
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