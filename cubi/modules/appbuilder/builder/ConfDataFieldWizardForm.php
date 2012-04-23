<?php 
class ConfDataFieldWizardForm extends EasyFormWizard
{
	public function deleteRecord($id=null)
	{
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        $db = $this->_getDBConn();
        $tableName = $this->getViewObject()->getTableName();
        foreach ($selIds as $id)
        {      
        	$sql = "ALTER TABLE `$tableName` DROP `$id`;";
        	$db->query($sql);
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
	}
	
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
			$infoArr = $tableInfos[$fieldName];
			if($infoArr['Null']=='YES')
			{
				$infoArr['SetNull']="1";
			}
			else
			{
				$infoArr['SetNull']="0";
			}
			return $infoArr;
		}		
	}
	   
	
}