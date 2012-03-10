<?php
class UserStatFilterForm extends EasyForm
{
	public $m_Year;
	public $m_Month;
	public $m_RecordId;
	
	public function runSearch()
	{	
		$data = $this->readInputRecord();		
		$this->m_Year = $data['year'];
		$this->m_Month = $data['month'];
		unset( $_POST['year_selector'] );
		unset( $_POST['month_selector'] );
		//$result = parent::runSearch();

		$this->m_SearchPanel->get('year_selector')->setValue($this->m_Year);
		$this->m_SearchPanel->get('month_selector')->setValue($this->m_Month); 
		
		$this->processFilter();
		
		$recId = $this->getDataObj()->fetchOne("[username]='".$data['username']."'")->Id;						
		$this->selectRecord($recId);
		$this->m_RecordId = $recId;
		
		$this->rerender(1,0);
		return $result;
	}
	
	public function processFilter(){
		$start_time = $this->m_Year.'-'.$this->m_Month.'-01 00:00:00';
		if((int)$this->m_Month==12)
		{
			$end_time = ($this->m_Year+1).'-01-01 00:00:00';
		}
		else
		{
			$end_time = $this->m_Year.'-'.((int)$this->m_Month+1).'-01 00:00:00';
		}
		
		
		//for filter create time
		$searchRule = "[create_time] > '$start_time' AND [create_time]<'$end_time' ";		
		BizSystem::getObject("collab.statistics.widget.ContactListDetailForm")->m_FixSearchRule=$searchRule;
		BizSystem::getObject("collab.statistics.widget.DocumentListDetailForm")->m_FixSearchRule=$searchRule;
		
		//for filter only start time in selected range and start at before still not finished
		$searchRule = "( ([start_time] > '$start_time' AND [start_time]<'$end_time' ) OR ( [start_time]<'$start_time' AND [status]!=2 ) )";	
		BizSystem::getObject("collab.statistics.widget.ProjectListDetailForm")->m_FixSearchRule=$searchRule;
		
		//for filter only start time in selected range and start at before still not finished
		//$searchRule = "( ([start_time] <= '$end_time' AND [finish_time]>'$start_time' ) OR ( [start_time]<'$start_time' AND [status]!=2 ) )";	
		$searchRule = "( ([start_time] <= '$end_time' AND [finish_time]>'$start_time' )  )";
		BizSystem::getObject("collab.statistics.widget.TaskListDetailForm")->m_FixSearchRule=$searchRule;
		
		$searchRule = "( ([start_time] <= '$end_time' AND [end_time]>'$start_time' )  )";
		BizSystem::getObject("collab.statistics.widget.EventListDetailForm")->m_FixSearchRule=$searchRule;
	}
	
	public function ViewAll()
	{
		$data = $this->readInputRecord();
		$recId = $this->getDataObj()->fetchOne("[username]='".$data['username']."'")->Id;
		$this->m_RecordId = $recId;
		
		$defaultSearchRule = "";
		BizSystem::getObject("collab.statistics.widget.ContactListDetailForm")->m_FixSearchRule=$defaultSearchRule;
		BizSystem::getObject("collab.statistics.widget.DocumentListDetailForm")->m_FixSearchRule=$defaultSearchRule;
		BizSystem::getObject("collab.statistics.widget.EventListDetailForm")->m_FixSearchRule=$defaultSearchRule;
		BizSystem::getObject("collab.statistics.widget.ProjectListDetailForm")->m_FixSearchRule=$defaultSearchRule;
		BizSystem::getObject("collab.statistics.widget.TaskListDetailForm")->m_FixSearchRule=$defaultSearchRule;
		
				
		$this->selectRecord($recId);
		
	}
	
	public function fetchData()
	{
		$result = parent::fetchData();
		$this->m_SearchPanel->get('session_uid')->setValue($result['username']);
		return $result;
	}
	
	
	public function render(){
		$result = parent::render();
		
		if($_GET['fld:Id'])
		{
			$recId= $_GET['fld:Id'];
		}
		elseif($this->m_RecordId)
		{		
			$recId= $this->m_RecordId;
		}
		else
		{
			$recId=BizSystem::getUserProfile("profile_Id");
		}
		
		if(!$this->m_Month){
			$this->m_Month = date('m');
		}
		
		if(!$this->m_Year){
			$this->m_Year = date('Y');
		}
		$this->selectRecord($recId);
		return $result;
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