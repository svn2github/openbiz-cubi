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

		$recId = $this->getDataObj()->fetchOne("[username]='".$data['username']."'")->Id;		
		$this->selectRecord($recId);
		$this->m_RecordId = $recId;
		return $result;
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