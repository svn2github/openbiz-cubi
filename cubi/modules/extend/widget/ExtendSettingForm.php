<?php 
class ExtendSettingForm extends EasyForm
{
	public $m_ParentFormElementMeta;
	
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
	
}
?>