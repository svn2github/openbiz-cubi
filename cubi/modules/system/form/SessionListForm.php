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
				$record['create_time_display'] = date("m-d",strtotime($record['create_time']));	
			}
			if(date("Y-m-d",strtotime($record['update_time']))==date("Y-m-d")){
				$record['update_time_display'] = date("H:i",strtotime($record['update_time']));
			}else{
				$record['update_time_display'] = date("m-d",strtotime($record['update_time']));	
			}			
			if($record['user_id']>0){
				$record['link'] = APP_INDEX.'/system/user_detail/'.$record['user_id']; 
			}else{
				$record['link'] = "javascript:;";
			}
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}  	
	
	public function CleanUp()
	{
		 $this->getDataObj()->deleteRecords("[user_id]=0");
		 $this->updateForm();
		 return ;
	}
}
?>