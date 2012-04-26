<?php
class DataObjectListForm extends EasyForm
{
	public function fetchDataSet()
	{
		$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$objList = $svc->listDataObjects($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getDataObjectInfo($obj);
    		$result[] = $objInfo;
    	}
    	
    	//set default selected record
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Name"];
		}
		//set paging 
		$this->m_TotalRecords = count($result);
			
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		
        if($this->m_CurrentPage > $this->m_TotalPages)
        {
        	$this->m_CurrentPage = $this->m_TotalPages;
        }
            
        if(is_array($result)){
			$result = array_slice($result,($this->m_CurrentPage-1)*$this->m_Range,$this->m_Range);
		}	    
            
    	return $result;
	}	
}
?>