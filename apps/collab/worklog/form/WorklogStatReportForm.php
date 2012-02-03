<?php
require_once MODULE_PATH.'/chart/form/ChartForm.php'; 
class WorklogStatReportForm extends ChartForm
{
	public $m_Year;
	public $m_Month;
	
	public function fetchDatasetByColumn(){
		if(!$this->m_Year){
			$this->m_Year = date('Y');
		}
		if(!$this->m_Month){
			$this->m_Month = date('m');
		}
		
		//get data range search rule
		
		$start_date = $this->m_Year.'-'.$this->m_Month.'-01 00:00:00';
		$end_date = $this->m_Year.'-'.$this->m_Month.'-'.date('t',strtotime($start_date)).' 00:00:00';		
		$searchRule = "([create_time]>'$start_date' AND [create_time]<'$end_date')";
		//$this->getDataObj()->setSearchRule($searchRule,1);
		return parent::fetchDatasetByColumn();
	}
	
	public function updateForm()
	{
		$data = $this->readInputRecord();		
		$this->m_Year = $data['year'];
		$this->m_Month = $data['month'];
		
		
		$start_date = $this->m_Year.'-'.$this->m_Month.'-01 00:00:00';
		$end_date = $this->m_Year.'-'.$this->m_Month.'-'.date('t',strtotime($start_date)).' 00:00:00';		
		$searchRule = "([create_time]>'$start_date' AND [create_time]<'$end_date')";
		//$this->getDataObj()->setSearchRule($searchRule,1);
		return parent::updateForm();
	}
	
    public function getSessionVars($sessionContext)
    {    	
    	$sessionContext->getObjVar($this->m_Name, "Year", $this->m_Year);
        $sessionContext->getObjVar($this->m_Name, "Month", $this->m_Month);
        return parent::getSessionVars($sessionContext);
    }


    public function setSessionVars($sessionContext)
    {
    	$sessionContext->setObjVar($this->m_Name, "Year", $this->m_Year);
        $sessionContext->setObjVar($this->m_Name, "Month", $this->m_Month);
        return parent::setSessionVars($sessionContext);        
    }    	
}
?>