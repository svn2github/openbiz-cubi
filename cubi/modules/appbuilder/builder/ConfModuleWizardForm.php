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
			$objectName = str_replace("_"," ",$tableName);
			$objectNameSpacing = ucwords($objectName);
			$objectName = str_replace(" ","",$objectNameSpacing);
		}
		else 
		{
			$objectNameSpacing = $objectName = ucfirst($names[0]);
		}
		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$moduleList = $svc->listModules();
    	if(!isset($_POST['fld_module_type'])){
	    	if(in_array(strtolower($names[0]), $moduleList))
	    	{
	    		$moduleType="0";
	    	}
	    	else
	    	{
	    		$moduleType="1";
	    	}    	
    	}else{
    		$moduleType = $_POST['fld_module_type'];    		
    	}
		$result['object_name'] = $objectName."DO";
		$result['object_desc'] = $objectNameSpacing." Description";
		$result['module_type'] = $moduleType;
		$result['module_name_create'] = strtolower($names[0]);
		$result['module_name_exists'] = strtolower($names[0]);
		$result['extend_type_do'] = $objectName."TypeDO";
		$result['extend_type_desc'] = $objectNameSpacing." Type Description";
		
		return $result;
	}
}
?>