<?php 
class ModuleDetailView extends EasyView
{
	
    public function render()
    {
    	BizSystem::getObject("appbuilder.metaedit.ModuleInfoForm")->fetchData();
    	foreach ($this->m_FormRefs as $key => $formRef)
        {
            $formRef->setViewName($this->m_Name);
            $formName = $formRef->m_Name;
            $formObj = BizSystem::getObject($formName);
            if($formName!='appbuilder.metaedit.ModuleInfoForm')
            {
            	$rs = $formObj->getRecordList();
            	$recs = count($rs);     
            	$formObj->m_SearchRule=null;  	 
            	if(!$recs)
            	{     
            		$emptyForms[]=$key;                   		
            	}
            }            
        }
        foreach($emptyForms as $form)
        {
        	$this->m_FormRefs->clear($form);
        }
        return parent::render();
    }	
	
}
?>