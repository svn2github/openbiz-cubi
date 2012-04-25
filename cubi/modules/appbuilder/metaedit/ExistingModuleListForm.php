<?php 
class ExistingModuleListForm extends EasyForm
{
	public function fetchDataSet()
	{
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$moduleList = $svc->listModules();
    	
    	foreach($moduleList as $module)
    	{
    		$moduleInfo = $svc->getModuleInfo($module);
    		$result[] = $moduleInfo;
    	}
    	
    	//set default selected record
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Name"];
		}
		//set paging 
		$this->m_TotalRecords = count($result);
		if(is_array($result)){
			$result = array_slice($result,($this->m_CurrentPage-1)*$this->m_Range,$this->m_Range);
		}		
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		
    	return $result;
	}
}
?>