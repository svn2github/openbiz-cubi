<?php 
class ExtendFieldForm extends PickerForm
{
	protected $m_SettingOptionDO = "extend.do.ExtendSettingOptionDO";
 	
	protected function _doUpdate($inputRecord, $currentRecord)
    {
    	$this->processOptions($inputRecord['options'], $currentRecord['Id']);
    	return parent::_doUpdate($inputRecord, $currentRecord);
    }
	
    
    public function insertToParent()
    {	
    	    	
    	$recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        

        if (!$this->m_ParentFormElemName)
        {
        	//its only supports 1-m assoc now	        	        
	        $parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
        	//$parentForm->getDataObj()->clearSearchRule();
	        $parentDo = $parentForm->getDataObj();
	        
	        $column = $parentDo->m_Association['Column'];
	    	$field = $parentDo->getFieldNameByColumn($column);	    	    	
	    	$parentRefVal = $parentDo->m_Association["FieldRefVal"];
	    	
			$recArr[$field] = $parentRefVal;
	    	if($parentDo->m_Association['Relationship']=='1-M'){	    			    	
		    	$cond_column = $parentDo->m_Association['CondColumn'];
		    	$cond_value = $parentDo->m_Association['CondValue'];
		    	if($cond_column)
		    	{
		    		$cond_field = $parentDo->getFieldNameByColumn($cond_column);
		    		$recArr[$cond_field] = $cond_value;
		    	}    
		    	$recId = $parentDo->InsertRecord($recArr);	
	    	}else{
	    		$recId = $this->getDataObj()->InsertRecord($recArr);	    			    		
	    		$this->addToParent($recId);
	    	}
	    	
	    	$this->processOptions($recArr['options'], $recId);
        }                

        if ($this->m_ParentFormElemName && $this->m_PickerMap)
        {
            return ; //not supported yet
        }
       
        
        $selIds[] = $recId;
        
        $this->close();	      
        if($parentForm->m_ParentFormName){
        	$parentParentForm = BizSystem::objectFactory()->getObject($parentForm->m_ParentFormName);
        	$parentParentForm->rerender();
        }
        else
        {       
        	$parentForm->rerender();
        }
    	return $recordId;
    }
    
    public function processOptions($option_str,$setting_id,$lang=null)
    {
    	$optDO = BizSystem::getObject($this->m_SettingOptionDO);
    	$optionArr = explode(";", $option_str);
    	$i=1;
    	$setting_id = (int)$setting_id;
    	$optDO->deleteRecords("[setting_id]='$setting_id' AND lang='$lang'");
    	foreach ($optionArr as $option)
    	{
    		$optRec = array(
    			"setting_id" => (int)$setting_id,
    			"lang" => $lang,
    			"text" => $option,
    			"value" => $i
    		);
    		$optDO->insertRecord($optRec);
    		$i++;
    	}
    } 	
}
?>