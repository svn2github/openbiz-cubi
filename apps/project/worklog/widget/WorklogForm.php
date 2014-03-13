<?php
class WorklogForm extends PickerForm
{
	public function insertToParent()
	{
		$recArr = $this->readInputRecord();
		$taskDO = BizSystem::getObject("project.task.do.TaskDO");
		$taskDO->clearSearchRule();
		$taskRec = $taskDO->fetchById($recArr['task_id']);			
		$taskRecNew['Id'] = $taskRec['Id'];
		$taskRecNew['progress'] =  $recArr['progress'];			
		$taskDO->updateRecord($taskRecNew,$taskRec);
		$taskDO->clearSearchRule();
		
		return parent::insertToParent();
	}
}