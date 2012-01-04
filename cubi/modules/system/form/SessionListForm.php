<?php
class SessionListForm extends EasyForm
{
	public function fetchDataSet()
	{		
		$resultSet = parent::fetchDataSet();
		$recordSet = array();		
		foreach ($resultSet as $record)
		{
			if(date("Y-m-d",strtotime($record['create_time']))==date("Y-m-d")){
				$record['create_time_display'] = date("H:i",strtotime($record['create_time']));
			}else{
				$record['create_time_display'] = date("m/d",strtotime($record['create_time']));	
			}
			if(date("Y-m-d",strtotime($record['update_time']))==date("Y-m-d")){
				$record['update_time_display'] = date("H:i",strtotime($record['update_time']));
			}else{
				$record['update_time_display'] = date("m/d",strtotime($record['update_time']));	
			}							
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}  	
}
?>