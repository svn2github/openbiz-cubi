<?php 
class NewAppWizardForm extends EasyViewWizard
{
    protected function _getDBConn()
    {
    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbName);
		return $db;
    }	
}
?>