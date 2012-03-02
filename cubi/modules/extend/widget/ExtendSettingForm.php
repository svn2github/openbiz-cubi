<?php 
class ExtendSettingForm extends EasyForm
{
	public $m_ParentFormElementMeta;
	public $m_AccessSelectFrom;
	
	public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->m_Name, "ParentFormElementMeta", $this->m_ParentFormElementMeta);
        return parent::getSessionVars($sessionContext);
    }

    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar($this->m_Name, "ParentFormElementMeta", $this->m_ParentFormElementMeta);
        return parent::setSessionVars($sessionContext);       
    }

    public function fetchDataSet()
    {
    	$this->m_AccessSelectFrom = $this->m_ParentFormElementMeta["ATTRIBUTES"]['ACCESSSELECTFROM'];
    	return parent::fetchDataSet();
    }
	
}
?>