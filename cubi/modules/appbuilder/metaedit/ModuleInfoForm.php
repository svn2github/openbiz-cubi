<?php 
class ModuleInfoForm extends EasyForm
{
	public $m_RecordId;
	
	public function fetchData()
	{
		$module = $_GET['mod'];
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	if(is_dir(MODULE_PATH.DIRECTORY_SEPARATOR.$module))
    	{
    		$result = $svc->getModuleInfo($module);
    	}    
    	$this->m_RecordId = $module;
    	return $result;
	}
}
?>