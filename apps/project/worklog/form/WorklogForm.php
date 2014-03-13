<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class WorklogForm extends ChangeLogForm
{
	public function insertRecord(){
		//process update task progress
		$recArr = $this->readInputRecord();
		if($recArr['task_id']){
			$taskDO = BizSystem::getObject("project.task.do.TaskDO");
			$taskDO->clearSearchRule();
			$taskRec = $taskDO->fetchById($recArr['task_id']);			
			$taskRecNew['Id'] = $taskRec['Id'];
			$taskRecNew['progress'] =  $recArr['progress'];			
			$taskDO->updateRecord($taskRecNew,$taskRec);
			$taskDO->clearSearchRule();
		}
		
		return parent::insertRecord();
	}
}
?>