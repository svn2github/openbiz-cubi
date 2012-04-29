<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';
class TemplateListForm extends ArrayListForm
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
    	$objList = $svc->listTemplates($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getTemplateInfo($obj);
    		$result[] = $objInfo;
    	}
    	return $result;
	}	
}
?>