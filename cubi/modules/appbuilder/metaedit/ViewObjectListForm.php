<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';
class ViewObjectListForm extends ArrayListForm
{
	public function GetRecordList()
	{
		if($this->getViewObject()->m_Name=='appbuilder.view.ModuleDetailView')
		{
			$module = BizSystem::getObject("appbuilder.metaedit.ModuleInfoForm")->m_RecordId;
		}
		else
		{
			$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		}
		
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