<?php 
class BuildCompletedWizardForm extends EasyFormWizard
{
	public $m_DataObjFiles = array();
	public $m_FormObjFiles = array();
	public $m_ViewObjFiles = array();
	public $m_MessageFiles = array();
	public $m_TemplateFiles = array();
	public $m_ModXMLFile ;

    public function getSessionVars($sessionContext)
    {
    	parent::getSessionVars($sessionContext);
        $sessionContext->getObjVar($this->m_Name, "DataObjFiles", 	$this->m_DataObjFiles);
        $sessionContext->getObjVar($this->m_Name, "FormObjFiles", 	$this->m_FormObjFiles);
        $sessionContext->getObjVar($this->m_Name, "ViewObjFiles", 	$this->m_ViewObjFiles);
        $sessionContext->getObjVar($this->m_Name, "MessageFiles", 	$this->m_MessageFiles);
        $sessionContext->getObjVar($this->m_Name, "TemplateFiles", 	$this->m_TemplateFiles);
        $sessionContext->getObjVar($this->m_Name, "ModXMLFile", 	$this->m_ModXMLFile);
    }

    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "DataObjFiles", 	$this->m_DataObjFiles); 
        $sessionContext->setObjVar($this->m_Name, "FormObjFiles", 	$this->m_FormObjFiles);
        $sessionContext->setObjVar($this->m_Name, "ViewObjFiles", 	$this->m_ViewObjFiles);
        $sessionContext->setObjVar($this->m_Name, "MessageFiles", 	$this->m_MessageFiles);
        $sessionContext->setObjVar($this->m_Name, "TemplateFiles", 	$this->m_TemplateFiles);
        $sessionContext->setObjVar($this->m_Name, "ModXMLFile", 	$this->m_ModXMLFile);            
    }	
	
	public function outputAttrs()
	{		
		$result = parent::outputAttrs();
		$result['DataObjFiles']	= $this->m_DataObjFiles;
		$result['FormObjFiles'] = $this->m_FormObjFiles;
		$result['ViewObjFiles'] = $this->m_ViewObjFiles;
		$result['MessageFiles'] = $this->m_MessageFiles;
		$result['TemplateFiles'] = $this->m_TemplateFiles;
		$result['ModFile'] 	= $this->m_ModXMLFile;
		return $result;
	}
}
?>