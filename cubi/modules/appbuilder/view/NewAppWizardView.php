<?php 
class NewAppWizardView extends EasyViewWizard
{
	public function getDBConn()
    {
    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();		
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbName);
		return $db;
    }	
    
    public function getDBConnName()
    {
    	if($this->m_FormStates['appbuilder.builder.ConfDataTableWizardForm']['visited'])
    	{  
	    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
			$dbRec = $dbConnForm->getActiveRecord();		
			$dbName = $dbRec['NAME'];		
    	}
		return $dbName;
    }	
    
	public function getTableName()
    {
    	if($this->m_FormStates['appbuilder.builder.ConfDataTableWizardForm']['visited'])
    	{    		    	
	    	$dbTableForm = BizSystem::getObject("appbuilder.builder.ConfDataTableWizardForm");
			$tableName = $dbTableForm->m_RecordId;		
			return $tableName;
    	}
    }    
    
    public function getFields()
    {
    	if($this->m_FormStates['appbuilder.builder.ConfDataFieldWizardForm']['visited'])
    	{
	    	$dbForm = BizSystem::getObject("appbuilder.builder.ConfDataFieldWizardForm");
			$fields = $dbForm->m_SelectedFields;
			return $fields;
    	}
    }

    public function renderStep($step)
    {
    	parent::renderStep($step);            
		switch(strtoupper($this->m_NaviMethod)){
			case "SWITCHFORM":
				$objectName = "appbuilder.builder.widget.SummaryLeftWidget";
				$formObj = BizSystem::getObject($objectName);
				$formObj->rerender();			
				break;							
		}
    }    
    
}
?>