<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class TaskTimesheetForm extends ChangeLogForm
{
	public $m_week_num ;
	public $m_year_num ;
	public $m_start_date ;
	public $m_end_date ;
	
	public function fetchDataSet()
	{				
		$this->calcDateRange();

		$do = $this->getDataObj();
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
		

		$start_date = new DateTime($this_year.'-01-01');
		$start_date->add(new DateInterval('P'.(($week_num-1)*7).'D'));
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

}
?>