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
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if($formName!='appbuilder.metaedit.ModuleInfoForm')
            {
            	$rs = $formObj->fetchDataSet();
            	$recs = count($rs);
            	            	
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