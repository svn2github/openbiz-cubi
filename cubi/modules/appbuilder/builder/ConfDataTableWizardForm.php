<?php 
class ConfDataTableWizardForm extends EasyFormWizard
{

	public function deleteRecord($id=null)
	{
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        $db = $this->_getDBConn();
        foreach ($selIds as $id)
        {      
        	$sql = "DROP TABLE IF EXISTS `$id`;";
        	$db->query($sql);
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
	}
	
	public function getActiveRecord($recId=null)
    {
        if ($this->m_ActiveRecord != null)
        {
            if($this->m_ActiveRecord['Id'] != null)
            {
                return $this->m_ActiveRecord;
            }
        }

        if ($recId==null || $recId=='')
            $recId = BizSystem::clientProxy()->getFormInputs('_selectedId');
        if ($recId==null || $recId=='')
            return null;
        $this->m_RecordId = $recId;
		$rec=array();
        
		$rec = $this->fetchTableInfo($recId);
        
		$this->m_DataPanel->setRecordArr($rec);
        $this->m_ActiveRecord = $rec;
        return $rec;
    }	
    
    protected function _getDBConn()
    {
    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbname);
		return $db;
    }
	
    public function fetchTableInfo($tableName)
    {
    	$db = $this->_getDBConn();
		$tableInfos = $db->fetchAssoc("SHOW TABLE STATUS WHERE Name='$tableName'");
		return $tableInfos[$tableName];
    }
    
    
	public function fetchDataSet()
	{
		$db = $this->_getDBConn();
    	$tblCols = $db->listTables();
    	
		try
    	{
    		$tableInfos = $db->fetchAssoc("SHOW TABLE STATUS");
    		foreach($tableInfos as $tableInfo)
	    	{
	    		$tableInfo["Id"] = $tableInfo['Name'];
	    		$result[] = $tableInfo;
	    	}
    	}
    	catch(Exception $e){
	    	foreach($tblCols as $tableName)
	    	{
	    		$tableInfo=array(
	    			"Name"=>$tableName,
	    		);
	    		$tableInfo["Id"] = $tableInfo['Name'];
	    		$result[] = $tableInfo;
	    	}	
    	}
    	
    	//set default selected record
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Name"];
		}
		
		//set paging 
		$this->m_TotalRecords = count($result);
		$result = array_slice($result,($this->m_CurrentPage-1)*$this->m_Range,$this->m_Range);		
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		
    	return $result;
	}
	
}
?>