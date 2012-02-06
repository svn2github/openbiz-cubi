<?php 
class WorklogReportStatDO extends BizDataObj
{
	
	public $m_Empty=FALSE;

    public function getSessionVars($sessionContext)
    {    	    	
        $sessionContext->getObjVar($this->m_Name, "Empty", $this->m_Empty);
        return parent::getSessionVars($sessionContext);
    }


    public function setSessionVars($sessionContext)
    {    	
        $sessionContext->setObjVar($this->m_Name, "Empty", $this->m_Empty);
        return parent::setSessionVars($sessionContext);        
    }  	
	
	public function fetch()
	{		
		if($this->m_SearchRule){
			$this->m_SearchRule = str_replace("[chart_type]  = :_v1", "", $this->m_SearchRule);		
		}
		
		//get stat data for avg level
		if($this->m_SearchRule)
		{
				$searchRule = $this->m_SearchRule;
		}else{
				$searchRule = "";
		}				
		$rows = parent::directFetch($searchRule);
		
		if(count($rows))
		{
			$row = $rows[0];
			$create_date = date("Y-m-d",strtotime($row['create_time']));
			$month = date("Y-m",strtotime($row['create_time']));
			$month_days = date("t",strtotime($create_date));
			$this->m_Empty = false;
		}else{
			$this->m_Empty = true;
		}
		$dataset_avg = array();
		foreach($rows as $row)
		{
			$create_date = date("Y-m-d",strtotime($row['create_time']));
			$users_count = BizSystem::getObject("collab.statistics.do.WorklogReportUserCountDO")->directfetch($this->m_SearchRule)->count();
			if($users_count>0){
				$row['data_count_avg'] = sprintf("%.2f",$row['data_count']/$users_count);
			}else{
				$row['data_count_avg'] = 0;
			}
			$dataset_avg[$create_date] = $row;
		}		
		
		//get stat data for my data
		$prtForm = BizSystem::getObject("collab.statistics.form.UserWorkhourReportForm");
		$my_user_id = $prtForm->m_RecordId;
				
		if($searchRule)
		{
				$searchRule .= " AND [create_by]='$my_user_id' ";
		}else{
				$searchRule = " [create_by]='$my_user_id' ";
		}
		$rows = parent::directFetch($searchRule);
		
		$dataset_mine = array();
		foreach($rows as $row)
		{
			$create_date = date("Y-m-d",strtotime($row['create_time']));
			$dataset_mine[$create_date] = $row;
		}
		
		$resultSet = array();
		for($i=1;$i<=$month_days;$i++)
		{			
			$record = array();
			$day = sprintf("%02d",$i);
			$new_date = $month.'-'.$day;
			$record['Id'] = strtotime($new_date);
			$record['date'] = $new_date;
			$record['date_d'] = (int)date('d',strtotime($new_date));
			$record['workhour_avg']	= sprintf("%.2f",$dataset_avg[$new_date]['data_count_avg']);
			$record['workhour_mine']= sprintf("%.2f",$dataset_mine[$new_date]['data_count']);
			$resultSet[] = $record;
		}
		return $resultSet;
	}
	

	
}
?>