<?php 
class HelpCategoryForm extends EasyFormTree
{
	protected $m_CategoryMappingDO 	= "help.do.HelpCategoryMappingDO";
	
	public function UpdateRecord(){
		$result = parent::UpdateRecord();
		$mappingObj  =  BizSystem::GetObject($this->m_CategoryMappingDO,1);
		$Id = $this->m_RecordId;
		$mappingObj->deleteRecords("[cat_id]='$Id'");
		return $result;
	}
	
	protected function validateForm($cleanError = true)
    {
    	
    	$result = parent::validateForm($cleanError);
    	
        if($result)
        {
        	$parentId = $this->m_DataPanel->get("fld_parent_id")->m_Value;
        	$currentId = $this->m_DataPanel->get("fld_Id")->m_Value;
		    if ($parentId == $currentId && strtoupper($this->m_FormType)=='EDIT')
	        {
	            $errorMessage = $this->getMessage("FORM_PARENT_SHOULD_NOT_SAME_AS_ITSELF");                                
	            $this->m_ValidateErrors[$element->m_Name] = $errorMessage;
	        }           
			
	        if (!$this->hasRootExcept($currentId) && strtoupper($this->m_FormType)=='EDIT')
	        {
	        	$errorMessage = $this->getMessage("FORM_ITS_LAST_ROOT_CATEGORY");                                
	            $this->m_ValidateErrors[$element->m_Name] = $errorMessage;
	        }
	        
	        /* todo:
        	if ($this->isMovedToChild($parentId,$currentId) && strtoupper($this->m_FormType)=='EDIT')
	        {
	        	$errorMessage = $this->getMessage("FORM_CANNOT_MOVE_ITS_CHILD");                                
	            $this->m_ValidateErrors[$element->m_Name] = $errorMessage;
	        }
	        */
	        
	        if (count($this->m_ValidateErrors) > 0)
	        {
	            throw new ValidationException($this->m_ValidateErrors);
	            return false;
	        }
        }
        return $result;
    } 
    
    protected function hasRootExcept($currentId)
    {
    	$rs = $this->getDataObj()->fetchOne("[PId]=0 AND [Id]!='".(int)$currentId."'");
    	if($rs){
	    	return true;
    	}else{
    		return false;
    	}    
    }
    

}
?>