<?php 
class DashboardWidgetForm extends EasyForm
{
	public function fetchDataSet()
	{		
		$resultSet = parent::fetchDataSet();
		$recordSet = array();		
		foreach ($resultSet as $record)
		{
			
			if($record['recurrence'])
			{
				$records = $this->getRepeatEvents($record);
				foreach ($records as $rec)
				{
					$rec = $this->getDisplayTime($rec);
					$recordSet[strtotime($rec['start_time'])] = $rec;
				}
			}
			else
			{
				$record = $this->getDisplayTime($record);
				$recordSet[strtotime($record['start_time'])] = $record;	
			}													
		}
		unset($svc);
		ksort($recordSet);
		$recordResult = array();
		$i=0;
		foreach($recordSet as $rec)
		{
			if(strtotime($rec['start_time'])>time()){
				array_push($recordResult, $rec);
				$i++;
			}						
			if($i>$this->m_Range){
				break;
			}
			
		}
		return $recordResult;
	} 
	
	public function getDisplayTime($record)
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
			return $record;
	}
	
	public function getRepeatEvents($record)
	{
		/**
		 *    
		   <RecurrenceType Value="0" text="None"/>
		   <RecurrenceType Value="1" text="Daily"/>
		   <RecurrenceType Value="2" text="Weekly"/>
		   <RecurrenceType Value="3" text="Monthly"/>
		   <RecurrenceType Value="4" text="Annually"/>         
		 */
		$records = array();
		switch($record['recurrence'])
		{
			case "1":
				for($i=0;$i<$this->m_Range;$i++){
					$rec = $record;
					$new_start_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d")." ".date("H:i:s",strtotime($record['start_time'])))+86400*$i);
					$new_end_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d")." ".date("H:i:s",strtotime($record['end_time'])))+86400*$i);															
					$rec['start_time'] = $new_start_time;
					$rec['end_time'] = $new_end_time;
					$records[strtotime($rec['start_time'])]=$rec;					
				}
				break;
			case "2":
				for($i=0;$i<$this->m_Range;$i++){
					$rec = $record;
					$new_start_time = strtotime($record['start_time']);		
					$weekday_org = date('w',$new_start_time);
					$weekday_cur = date('w');			
					$weekday_diff = $weekday_org - $weekday_cur ;					
					$dayinthisweek = time() + $weekday_diff*86400 + 7*86400*$i;													
					$rec['start_time'] = date("Y-m-d",$dayinthisweek)." ".date("H:i:s",strtotime($record['start_time']));					
			    	
					$new_end_time = strtotime($record['end_time']);		
					$weekday_org = date('w',$new_end_time);
					$weekday_cur = date('w');			
					$weekday_diff = $weekday_org - $weekday_cur ;					
					$dayinthisweek = time() + $weekday_diff*86400 + 7*86400*$i;													
					$rec['end_time'] = date("Y-m-d",$dayinthisweek)." ".date("H:i:s",strtotime($record['end_time']));;
					
					
					$records[strtotime($rec['start_time'])]=$rec;					
				} 
				break;
			case "3":
				for($i=0;$i<$this->m_Range;$i++){
					$rec = $record;
					$new_start_time = strtotime($record['start_time']);					
					if(date('m',$new_start_time)+$i>12){
						$month = date('m',$new_start_time)+$i - 12;
						$offset_y = 1;
					}else{
						$month = date('m',$new_start_time)+$i;
						$offset_y = 0;
					}					
					$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_start_time),
			      	date('i',$new_start_time), date('s',$new_start_time), $month,
			    	date('d',$new_start_time), date('Y')+$offset_y ));
					$rec['start_time'] = $newdate;					
			    	
					$new_end_time = strtotime($record['end_time']);
					if(date('m',$new_end_time)+$i>12){
						$month = date('m',$new_end_time)+$i - 12;
						$offset_y = 1;
					}else{
						$month = date('m',$new_end_time)+$i;
						$offset_y = 0;
					}					
					$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_end_time),
			      	date('i',$new_end_time), date('s',$new_end_time), $month,
			    	date('d',$new_end_time), date('Y')+$offset_y ));      										
					$rec['end_time'] = $newdate;
					
					$records[strtotime($rec['start_time'])]=$rec;					
				}
				break;
			case "4":
				for($i=0;$i<$this->m_Range;$i++){
					$rec = $record;
					$new_start_time = strtotime($record['start_time']);					
			      	$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_start_time),
			      	date('i',$new_start_time), date('s',$new_start_time), date('m',$new_start_time),
			    	date('d',$new_start_time), date('Y')+$i));      										
					$rec['start_time'] = $newdate;
										
					$new_end_time = strtotime($record['end_time']);
					$newdate = date('Y-m-d h:i:s', mktime(date('h',$new_end_time),
			      	date('i',$new_end_time), date('s',$new_end_time), date('m',$new_end_time),
			    	date('d',$new_end_time), date('Y')+$i));      										
					$rec['end_time'] = $newdate;
					
					$records[strtotime($rec['start_time'])]=$rec;					
				}
				break;
		}
		return $records;
	}
	

}
?>