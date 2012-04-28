<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';
class LovListForm extends ArrayListForm
{
	public function GetRecordList()
	{
		$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$objList = $svc->listLovs($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getLovInfo($obj);
    		$result[] = $objInfo;
    	}
    	return $result;
	}	
}
?>