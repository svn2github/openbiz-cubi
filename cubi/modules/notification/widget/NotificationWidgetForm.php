<?php 
class NotificationWidgetForm extends EasyForm
{
	public function render()
	{
		$result = parent::render();
		if(!$this->m_TotalRecords)
		{
			return "";
		}
		return $result;
	}
	
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		foreach($resultSet as $key => $record)
		{
			$record['release_date'] = date("Y-m-d",strtotime($record['create_time']));
			$resultSet[$key] = $record;
		}
		return $resultSet;
	}
	
	public function MarkRead($id)
	{
		$rec = $this->getDataObj()->fetchById($id);
		$rec['read_state']=1;
		$goto_url = $rec['goto_url'];
		$rec->save();
		if($goto_url)
		{
			$goto_url = APP_INDEX.$goto_url;
			BizSystem::clientProxy()->redirectPage($goto_url);
		}
	}
}
?>