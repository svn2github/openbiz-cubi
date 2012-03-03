<?PHP
include_once("Element.php");

class FormElement extends InputElement
{
    protected $m_FormReference;
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_FormReference = isset($xmlArr["ATTRIBUTES"]["FORMREFERENCE"]) ? $xmlArr["ATTRIBUTES"]["FORMREFERENCE"] : null;        
        $this->m_RenameElementSet = isset($xmlArr["ATTRIBUTES"]["RENAMEELEMENTSET"]) ? $xmlArr["ATTRIBUTES"]["RENAMEELEMENTSET"] : 'Y';
    }
    
    public function FormRecordCount()
    {
    	if(strtoupper($this->m_RenameElementSet)!='Y'){
    		return;
    	}
    	$formElementObj = BizSystem::GetObject($this->m_FormReference);
    	if(strtolower($formElementObj->m_FormType)!='list'){
    		return;
    	}
    	
    	$count = (int)$formElementObj->getDataObj()->count();
    	if($count<0){
    		return;
    	}
    	
    	$my_elementset = $this->m_ElementSet;
    	
    	//update other elements
    	$panel = $this->getFormObj()->m_DataPanel;
    	$panel->rewind();
        while($panel->valid())    	    	
        {      
        	$elem = $panel->current();
        	if($elem->m_ElementSet ){        		
        		if($elem->m_ElementSet == $my_elementset && !preg_match("/tab_label_count/si",$elem->m_ElementSet)){
        			$elem->m_ElementSet.=" <span class=\"tab_label_count\">$count</span>";
        		}
        	}     
        	$panel->next();        	                                  
        }
    }
    

    /**
     * Draw the element according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {    	
        if(!$this->m_FormReference)
        {
        	return null;
        }
        $formObj = $this->getFormObj();   
        $formElementObj = BizSystem::GetObject($this->m_FormReference);
        $formElementObj->m_ParentFormName = $formObj->m_Name;
        $formElementObj->m_ParentFormElementMeta = $this->m_XMLMeta;                
        if (method_exists($formObj,"SetSubForms"))
        {
                $formObj->setSubForms($this->m_FormReference);                
                $formDataObj = BizSystem::getObject($formObj->m_DataObjName);
                $dataObj = $formDataObj->getRefObject($formElementObj->m_DataObjName);
                
                if ($dataObj)
                    $formObj->setDataObj($dataObj);                
        }
    	$sHTML = $formElementObj->render();    	
    	$formObj->setDataObj($formDataObj);
    	$this->FormRecordCount();    	
        return $sHTML;
    }

    public function setValue($value)
    {
    	$formElementObj = BizSystem::GetObject($this->m_FormReference);
    	if(method_exists($formElementObj, "setValue"))
    	{
    		return $formElementObj->setValue($value);
    	}
    }
    
    public function getValue()
    {
    	$formElementObj = BizSystem::GetObject($this->m_FormReference);
    	if(method_exists($formElementObj, "getValue"))
    	{
    		return $formElementObj->getValue();
    	}
    }    
}

?>
