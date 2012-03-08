<?php 
class ProjectBriefForm extends EasyForm
{
	public function fetchData()
	{
		$formObj = BizSystem::getObject($this->m_ParentFormName);
		if(!$formObj)return false;
		
		$rec = $formObj->getActiveRecord();
		
		if($rec['project_id'])
		{
			$rec = $this->getDataObj()->fetchById($rec['project_id']);
			return $rec->toArray();
		}
		return false;		
	}
	
	public function render()
	{
		if($this->fetchData()){
			return parent::render();
		}else{
			return "";
		}
	}
} 
?>