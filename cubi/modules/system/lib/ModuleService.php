<?php 
class ModuleService
{
	protected $m_ModuleDO = "system.do.ModuleCachedDO";
	
	public function isModuleInstalled($module)
	{
		$do = BizSystem::getObject($this->m_ModuleDO);
		$modRec = $do->fetchOne("[module]='$module'");
		if($modRec)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
}
?>