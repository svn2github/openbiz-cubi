<?php 
class ConfDataFieldWizardForm extends EasyFormWizard
{

	public function fetchDataSet()
	{
		$db = $this->_getDBConn();
		$tableName = $this->getViewObject()->getTableName();
		if(!$tableName)return;
		$sql = "SHOW FULL COLUMNS FROM `$tableName`";
		$fieldsInfo = $db->fetchAssoc($sql);
		
    	foreach($fieldsInfo as $fieldInfo)
    	{
    		$fieldInfo["Id"] = $fieldInfo['Field'];
    		$result[] = $fieldInfo;
    	}
		
		//set default selected record
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Id"];
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
	
    protected function _getDBConn()
    {
    	return $this->getViewObject()->getDBConn();
    }
    
 	public function fetchFieldInfo($tableName,$fieldName)
	{
		if($fieldName && $tableName)
		{
	    	$db = $this->_getDBConn();    	
			$tableInfos = $db->fetchAssoc("SHOW FULL COLUMNS FROM `$tableName` WHERE Field='$fieldName';");
			return $tableInfos[$fieldName];
		}		
	}
	   
	
}