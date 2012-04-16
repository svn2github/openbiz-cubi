<?php 
class ConfDataTableWizardForm extends EasyFormWizard
{
	
	public function fetchDataSet()
	{
		$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbname);
    	$tblCols = $db->listTables();
    	
		try
    	{
    		$tableInfos = $db->fetchAssoc("SHOW TABLE STATUS");
    		foreach($tableInfos as $tableInfo)
	    	{
	    		$result[] = $tableInfo;
	    	}
    	}
    	catch(Exception $e){
	    	foreach($tblCols as $tableName)
	    	{
	    		$tableInfo=array(
	    			"Name"=>$tableName,
	    		);
	    		$result[] = $tableInfo;
	    	}	
    	}
    	
    	
    	return $result;
	}
	
}
?>