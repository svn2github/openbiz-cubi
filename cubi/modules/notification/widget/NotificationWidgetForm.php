<?php 
class NotificationWidgetForm extends EasyForm
{
	protected $m_ReadAccess;
	
	public function render()
	{
		$this->triggerCheckers();
		
		$result = parent::render();
		if(!$this->m_TotalRecords)
		{
			return "";
		}
		if($this->m_ReadAccess){
			if(BizSystem::allowUserAccess($this->m_ReadAccess))
			{
				return $result;
			}			
		}else{
			return $result;
		}
	}
	
	public function triggerCheckers()
	{
		$svc = BizSystem::getService("notification.lib.checkerService");
		$svc->checkNotification();
	}
	
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		foreach($resultSet as $key => $record)
		{
			$record['release_date'] = date("Y-m-d",strtotime($record['create_time']));
			$resultSet[$key] = $record;
		}
		$this->m_ReadAccess = $resultSet[0]['read_access'];
		return $resultSet;
	}
	
	public function MarkRead($id)
	{
		$rec = $this->getDataObj()->fetchById($id);
		$type		= $rec['type'];
		$goto_url 	= $rec['goto_url'];
		
		if($rec['update_access'])
		{
			if(BizSystem::allowUserAccess($rec['update_access']))
			{				
				$this->getDataObj()->deleteRecords("[type]='$type'");
			}
		}else{
			$this->getDataObj()->deleteRecords("[type]='$type'");
		}
		
		if($goto_url)
		{
			$goto_url = APP_INDEX.$goto_url;
			BizSystem::clientProxy()->redirectPage($goto_url);
		}else{
			BizSystem::clientProxy()->updateClientElement($this->m_Name,"" );
		}
	}
}
?>