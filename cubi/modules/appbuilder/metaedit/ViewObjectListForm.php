<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';
class ViewObjectListForm extends ArrayListForm
{
	public function GetRecordList()
	{
		$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$objList = $svc->listViewObjects($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getViewObjectInfo($obj);
    		$result[] = $objInfo;
    	}
    	return $result;
	}	
}
?>