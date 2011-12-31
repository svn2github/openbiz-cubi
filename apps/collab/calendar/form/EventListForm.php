<?php 
class EventListForm extends EasyForm
{
	public function fetchDataSet()
	{		
		$resultSet = parent::fetchDataSet();
		$recordSet = array();		
		foreach ($resultSet as $record)
		{
			if(date("Y-m-d",strtotime($record['start_time']))==date("Y-m-d")){
				$record['start_time_display'] = date("H:i",strtotime($record['start_time']));
			}else{
				$record['start_time_display'] = date("m/d",strtotime($record['start_time']));	
			}
			if(date("Y-m-d",strtotime($record['end_time']))==date("Y-m-d")){
				$record['end_time_display'] = date("H:i",strtotime($record['end_time']));
			}else{
				$record['end_time_display'] = date("m/d",strtotime($record['end_time']));	
			}							
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}    
}
?>