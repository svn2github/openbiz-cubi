<?php
class BuildOptionsWizardForm extends EasyFormWizard
{
	public $m_BuildOptions;
	
    public function getSessionVars($sessionContext)
    {
    	parent::getSessionVars($sessionContext);
        $sessionContext->getObjVar($this->m_Name, "BuildOptions", $this->m_BuildOptions);
    }

    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "BuildOptions", $this->m_BuildOptions);     
    }
	
	public function fetchData()    
	{    	            		
		if ($this->m_ActiveRecord != null)
            return $this->m_ActiveRecord;
    	
        if (strtoupper($this->m_FormType) == "NEW")
            return $this->getNewRecord();
            
        return parent::fetchData();
    }
	
	public function getNewRecord()
	{		
		$result = array();
		$tableName = $this->getViewObject()->getTableName();
		$names = explode("_", $tableName);
		$result['mod_desc'] = ucfirst($names[0])." Module Description";
		
		return $result;
	}

	public function goNext($commit=false)
	{		
		$rec = $this->readInputRecord();
		$this->m_BuildOptions = $rec;
		parent::goNext(false);
	}	
}
?>