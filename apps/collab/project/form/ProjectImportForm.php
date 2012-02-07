<?php
include_once dirname(__FILE__).'/ProjectForm.php';
class ProjectImportForm extends ProjectForm
{
	public function ImportTasks()
	{
		$rec = $this->readInputRecord();		
		if($rec['use_template']==1){
			$prefix = $rec['shortname'];
			$templateId = BizSystem::getObject("collab.project.widget.ProjectTemplateListForm")->m_RecordId;
			$projectRec = $this->getDataObj()->getActiveRecord();
			$this->createTasks($projectRec, $templateId, $prefix);
		}
		$this->processPostAction();
		return true;
	}
	
	public function createTasks($projectRec,$templateId,$prefix)
	{
		$taskTemplates = BizSystem::getObject("collab.project.do.ProjectTaskTemplateDO")->directFetch("[project_id]='$templateId'");
		$taskDo = BizSystem::getObject("collab.task.do.TaskSystemDO",1);
		//create tasks
		$taskMapping = array();
		foreach ($taskTemplates as $template){
			$newTask = $template;
			if($prefix){
				$newTask['title'] = $prefix.' - '.$newTask['title'];
			}
			$newTask['project_id'] = $projectRec['Id'];
			$newTask['start_time'] = $this->getWorkTime($projectRec['start_time'],$template['start_date']);
			$newTask['finish_time'] = $this->getWorkTime($projectRec['start_time'],$template['start_date']+$template['during_days']);;
			$newTask['total_workhour'] = $template['during_days']*8;
			unset($newTask['create_by']);
			unset($newTask['create_time']);
			unset($newTask['update_by']);
			unset($newTask['update_time']);
			$newTaskId = $taskDo->insertRecord($newTask);
			$taskMapping[$template["Id"]] = $newTaskId;
		}
		
		//setup dependency
		foreach ($taskTemplates as $template){
			if($template['dependency_task_id']){
				$taskRec = $taskDo->fetchById($taskMapping[$template['Id']]);
				$taskRec['dependency_task_id'] = $taskMapping[$template['dependency_task_id']];
				$taskRec->Save();
			}	
		}
	}
	
	protected function getWorkTime($target_time,$days)
	{
		$target_timestamp = strtotime($target_time);
		for($i=1;$i<=$days;$i++)
		{
			$target_timestamp+=86400;
			if( date('w',$target_timestamp)==6 || date('w',$target_timestamp)==0){
				$i=$i-1;
			}	
		}
		return date("Y-m-d H:i:s",$target_timestamp);
	}
}
?>