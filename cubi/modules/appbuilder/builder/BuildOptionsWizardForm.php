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
				
		$svc = BizSystem::getService("appbuilder.lib.MetaGeneratorService");
		$dbName			= $this->getViewObject()->getDBConnName();
		$dbTable		= $this->getViewObject()->getTableName();
		$dbFields		= $this->getViewObject()->getFields();		
		$configModule 	= $this->getViewObject()->getConfigModule();
		$buildOptions 	= $this->getViewObject()->getBuildOptions();
		
		$svc->setDBName($dbName);
		$svc->setDBTable($dbTable);
		$svc->setDBFields($dbFields);
		$svc->setConfigModule($configModule);
		$svc->setBuildOptions($buildOptions);		
		$generatedFiles = $svc->generate();
				
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_DataObjFiles  = $generatedFiles['DataObjFiles'];
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_FormObjFiles  = $generatedFiles['FormObjFiles'];
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_ViewObjFiles  = $generatedFiles['ViewObjFiles'];
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_MessageFiles  = $generatedFiles['MessageFiles'];
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_TemplateFiles = $generatedFiles['TemplateFiles'];
		BizSystem::getObject("appbuilder.builder.BuildCompletedWizardForm")->m_ModXMLFile	 = $generatedFiles['ModXMLFile'];
		
		parent::goNext(false);
	}	
}
?>