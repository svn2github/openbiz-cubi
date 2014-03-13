<?php 
class ProjectTaskTemplateForm extends EasyForm
{
	public function validateForm($cleanError = true)
	{
		$result = parent::validateForm($clearError);
		$recArr = $this->readInputRecord();
		if($recArr['dependency_task_id'])
		{
			//check start days
			$taskTempDO = BizSystem::getObject("project.project.do.ProjectTaskTemplateDO",1);
			$dependTaskRec = $taskTempDO->fetchById($recArr['dependency_task_id']);
			$earist_start_date = $dependTaskRec['start_date'] + $dependTaskRec['during_days'];
			if($recArr['start_date']<$earist_start_date)
			{
				$errorMessage = $this->getMessage("START_TIME_TOO_EARLY",array($earist_start_date+1));                                
                $this->m_ValidateErrors['fld_start_time'] = $errorMessage;
			}
		}
		if (count($this->m_ValidateErrors) > 0)
        {
            throw new ValidationException($this->m_ValidateErrors);
            return false;
        }
		return $result;
	}
}
?>