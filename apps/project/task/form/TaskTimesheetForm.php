<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class TaskTimesheetForm extends ChangeLogForm
{
	public $m_week_num ;
	public $m_year_num ;
	public $m_start_date ;
	public $m_end_date ;
	
	public function fetchDataGroup()
	{				
		$this->calcDateRange();
		$resultSet = array();
		for($i=0;$i<=6;$i++){
			$selected_date = date("Y-m-d",strtotime($this->m_start_date)+86400*$i); 
			$resultSet[] = $this->getTaskStat($selected_date);	
		}		
		return $resultSet;
	}
    public function outputAttrs()
    {
    	$output = parent::outputAttrs();
    	$output['dataGroup'] = $this->fetchDataGroup();    	
    	return $output;	
    
    } 
    public function selectRecord($recId){
    	$result = parent::selectRecord($recId);
    	$elem = $this->m_NavPanel->get('txt_sel_date');
    	BizSystem::clientProxy()->updateClientElement($elem->m_Name, $elem->render());
    }
    public function fetchDataSet()
	{		
		$this->calcDateRange();
		$svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	    $dataPermSQLRule = $svcObj->buildSqlRule($this->getDataObj(),'update',true,true);
	    $this->m_FixSearchRule = $dataPermSQLRule;				
		return array();
	}  
	public function getSessionVars($sessionContext)
    {    
        $sessionContext->getObjVar($this->m_Name, "WeekNum", $this->m_week_num);
        $sessionContext->getObjVar($this->m_Name, "YearNum", $this->m_year_num);
        return parent::getSessionVars($sessionContext);
    }

    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar($this->m_Name, "WeekNum", $this->m_week_num);
        $sessionContext->setObjVar($this->m_Name, "YearNum", $this->m_year_num);
        return parent::setSessionVars($sessionContext);        
    }	
	
	public function calcDateRange()
	{
		if($this->m_week_num)
		{
			$week_num = $this->m_week_num;
			$this_year = $this->m_year_num;
		}
		else
		{
			$this->m_week_num = $week_num = date('W',time());
			$this->m_year_num = $this_year = date('Y',time());			
		}		

		if(!$this->m_RecordId)
		{
			$this->m_RecordId = strtotime(date('Y-m-d',time()));
		}
		$start_date = new DateTime($this_year.'-01-01');
		$weekday_offset = date('w',strtotime($this_year.'-01-01'));		
		$start_date->add(new DateInterval('P'.((($week_num-1)*7)+1).'D'));
		$start_date->sub(new DateInterval('P'.$weekday_offset.'D'));
		
		$start_date_str = $start_date->format("Y-m-d")." 00:00:00";
		
		$end_date = $start_date;
		$end_date = $end_date->add(new DateInterval('P7D'));
		$end_date_str = $end_date->format("Y-m-d")." 23:59:59";

		$this->m_start_date = $start_date_str;
		$this->m_end_date = $end_date_str;
		
		return $this->m_start_date;
	}
	
	public function GotoWeek($week_num)
	{
		if($week_num<=1)
		{
			$this->m_year_num --;
			$week_num = 52;
		}
		if($week_num>52)
		{
			$this->m_year_num ++;
			$week_num = 1;
		}
        $this->m_week_num = $week_num;
        $this->rerender();
	}

	public function ChangeDateRange()
	{
		$data = $this->readInputs();		
		$this->m_year_num = (int)$data['year_selector'];
		$this->m_week_num = (int)$data['week_selector'];
        $this->rerender();
	}
	public function GotoToday()
	{
		$this->m_week_num = $week_num = date('W',time());
		$this->m_year_num = $this_year = date('Y',time());
        $this->rerender();
	}
	public function getTaskStat($sel_date){
		$searchRule = "
		(
			[start_time]<='$sel_date 23:59:59' AND
			[finish_time]>'$sel_date 00:00:00'
		) 
		";
		$svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	    $dataPermSQLRule = $svcObj->buildSqlRule($this->getDataObj(),'update',true,true);
	    $searchRule .= ' AND '.$dataPermSQLRule;	
	    
		$recs = BizSystem::getObject('project.task.do.TaskStatDO',1)->directfetch($searchRule);
		$statData = array();
		foreach($recs as $rec)
		{
			$statData[$rec['Id']] = $rec['num'];
		}
		
		$total_tasks = (int)array_sum($statData);
		if($sel_date == date('Y-m-d'))
		{
			$is_today = true;
		}else{
			$is_today = false;
		}
		$bar_width=70;		
		$dataArr = array(
			"Id"			=>	strtotime($sel_date),
			"date"			=>	date('Y-m-d',strtotime($sel_date)),
			"weekdate"		=>	$this->getMessage("WEEKDAY_".date('w',strtotime($sel_date))),
			"dayofweek"		=>	date('w',strtotime($sel_date)),
			"not_started"	=>	(int)$statData[0],
			"in_progress"	=>	(int)$statData[1],
			"completed"		=>	(int)$statData[2],
			"other"			=>	(int)$statData[3]+(int)$statData[4],
			"total"			=>	$total_tasks,
			"istoday"		=>	$is_today,
		);
		
		if($total_tasks){
			$dataArr['not_started_wid'] = (int)($statData[0]/$total_tasks*$bar_width);
			$dataArr['in_progress_wid'] = (int)($statData[1]/$total_tasks*$bar_width);
			$dataArr['completed_wid'] = (int)($statData[2]/$total_tasks*$bar_width);
			$dataArr['other_wid'] = (int)(($statData[3]+(int)$statData[4])/$total_tasks*$bar_width);
		}else{
			$dataArr['not_started_wid'] = 2;
			$dataArr['in_progress_wid'] = 2;
			$dataArr['completed_wid'] = 2;
			$dataArr['other_wid'] = 2;
		}
		if($dataArr['not_started_wid']<2){$dataArr['not_started_wid'] = 2;}
		if($dataArr['in_progress_wid']<2){$dataArr['in_progress_wid'] = 2;}
		if($dataArr['completed_wid']<2){$dataArr['completed_wid'] = 2;}
		if($dataArr['other_wid']<2){$dataArr['other_wid'] = 2;}
		return $dataArr;
	}
	
    
}
?>