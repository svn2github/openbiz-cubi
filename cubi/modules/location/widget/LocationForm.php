<?php 
class LocationForm extends EasyForm
{
	
	public function close(){
		return parent::close();
	}
	

	public function deleteLocation($id)
	{
		parent::deleteRecord($id);	
		 $parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}

	public function UpdateLocation($id,$lat,$lng)
	{
		$location = $this->getDataObj()->fetchById($id);
		$location['latitude'] = $lat;
		$location['longtitude'] = $lng;
		$location->save();
		return ;
	}
	public function addLocation()
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
	    	$cond_column = $parentDo->m_Association['CondColumn'];
	    	$cond_value = $parentDo->m_Association['CondValue'];
	    	if($cond_column)
	    	{
	    		$cond_field = $parentDo->getFieldNameByColumn($cond_column);
	    		$recArr[$cond_field] = $cond_value;
	    	}    	
        }                

        if ($this->m_ParentFormElemName && $this->m_PickerMap)
        {
            return ; //not supported yet
        }
        $recId = $parentDo->InsertRecord($recArr);
        
        $parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}
}
?>