<?php
require_once MODULE_PATH.'/common/form/ArrayListForm.php';

class FormObjectListForm extends ArrayListForm
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
    	$objList = $svc->listFormObjects($module);
    	
    	foreach($objList as $obj)
    	{
    		$objInfo = $svc->getFormObjectInfo($obj);
    		$result[] = $objInfo;
    	}
    	    	    	
    	return $result;
	}	
	
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		$result = array();
		if(is_array($resultSet))
		{
			foreach($resultSet as $record)
			{
				if(!$record['FORMTYPE'])
				{
					$record['FORMTYPE'] = 'Detail';
				}
				$record['ICONTYPE'] = RESOURCE_URL.'/appbuilder/images/icon_form_'.strtolower($record['FORMTYPE']).'_small.png';
				$result[]=$record;
			}
		}
		else
		{
			$result = array();	
		}
		return $result;
	}
}
?>