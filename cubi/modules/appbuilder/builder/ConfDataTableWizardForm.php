<?php 
class ConfDataTableWizardForm extends EasyFormWizard
{
	
	public function fetchDataSet()
	{
		$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();
		//var_dump($dbRec);
	}
	
}
?>