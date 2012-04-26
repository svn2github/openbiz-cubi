<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';

class FormObjectListForm extends ArrayListForm
{
	public function GetRecordList()
	{
		$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$objList = $svc->listFormObjects($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getFormObjectInfo($obj);
    		$result[] = $objInfo;
    	}
    	    	    	
    	return $result;
	}	
}
?>