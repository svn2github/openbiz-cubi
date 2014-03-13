<?php 
class TaskNewForm extends PickerForm
{
	public $m_DefaultProject;
	
	public function fetchData()
	{
		if($this->m_ParentFormName)
		{
			$parentForm = BizSystem::getObject($this->m_ParentFormName);
			$this->m_DefaultProject = $parentForm->m_RecordId;
		}
		return parent::fetchData();
	}
}
?>