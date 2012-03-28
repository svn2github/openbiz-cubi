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
}
?>