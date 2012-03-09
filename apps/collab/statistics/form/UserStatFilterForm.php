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
		
		return $result;
	}
	
	public function render(){
		$result = parent::render();
		$this->selectRecord(BizSystem::getUserProfile("profile_Id"));
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