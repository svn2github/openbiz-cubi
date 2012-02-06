<?php
include_once (MODULE_PATH."/system/lib/ModuleLoadHandler.php");

class ContactLoadHandler implements ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader)
    {
    }
    
    public function postLoadingModule($moduelLoader)
    {
    	
    	$roleRec = BizSystem::getObject("system.do.RoleDO")->fetchOne("[name]='Cubi Member'");
    	$roleId = $roleRec['Id'];
    	
    	$actionRec = BizSystem::getObject("system.do.AclActionDO")->fetchOne("[module]='contact' AND [resource]='contact' AND [action]='access'");
    	$actionId = $actionRec["Id"];
    	
    	$aclRecord = array(
    		"role_id" =>  $roleId,
    		"action_id" => $actionId,
    		"access_level" => 1
    	);
    	BizSystem::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
    }
}

?>