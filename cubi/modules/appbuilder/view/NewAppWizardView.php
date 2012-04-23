<?php 
class NewAppWizardView extends EasyViewWizard
{
	public function getDBConn()
    {
    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();		
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbName);
		return $db;
    }	
    
	public function getTableName()
    {
    	$dbTableForm = BizSystem::getObject("appbuilder.builder.ConfDataTableWizardForm");
		$tableName = $dbTableForm->m_RecordId;
		return $tableName;
    }    
    
    public function getFields()
    {
    	$dbForm = BizSystem::getObject("appbuilder.builder.ConfDataFieldWizardForm");
		$fields = $dbForm->m_SelectedFields;
		return $fields;
    }
}
?>