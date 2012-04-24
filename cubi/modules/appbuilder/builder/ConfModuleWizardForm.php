<?php 
class ConfModuleWizardForm extends EasyFormWizard
{
	
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
		if($names[1])
		{
			$objectName = str_replace($names[0]."_","",$tableName);			
			$objectName = str_replace("_"," ",$objectName);
			$objectNameSpacing = ucwords($objectName);
			$objectName = str_replace(" ","",$objectNameSpacing);
		}
		else 
		{
			$objectName = $names[0];
		}
		$result['object_name'] = $objectName."DO";
		$result['object_desc'] = $objectNameSpacing." Description";
		$result['module_name_create'] = ucfirst($names[0]);
		$result['extend_type_do'] = $objectName."TypeDO";
		$result['extend_type_desc'] = $objectNameSpacing." Type Description";
		
		return $result;
	}
}
?>