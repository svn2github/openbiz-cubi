<?php
include_once (MODULE_PATH."/system/lib/ModuleLoadHandler.php");

class CollabLoadHandler implements ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader)
    {
    }
    
    public function postLoadingModule($moduelLoader)
    {
    	
    	$roleRec = BizSystem::getObject("system.do.RoleDO")->fetchOne("[name]='Collaboration Admin'");
    	$adminRoleId = $roleRec['Id'];
    	
    	$roleRec = BizSystem::getObject("system.do.RoleDO")->fetchOne("[name]='Collaboration Member'");
    	$memberRoleId = $roleRec['Id'];
    	
    	$actionList = BizSystem::getObject("system.do.AclActionDO")->fetchOne("[module]='collab'");
    	foreach ($actionList as $actionRec){
	    	$actionId = $actionRec["Id"];
	    	
	    	$aclRecord = array(
	    		"role_id" =>  $adminRoleId,
	    		"action_id" => $actionId,
	    		"access_level" => 1
	    	);
	    	BizSystem::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
	    	
		    if(
		    	($actionRec['name']=='manage' && $actionRec['resource']=='collab_announcement') ||
		     	($actionRec['name']=='access' && $actionRec['resource']=='collab_statistics')
		     ){
		     	continue;
		     }
		     	
	    	$aclRecord = array(
	    		"role_id" =>  $memberRoleId,
	    		"action_id" => $actionId,
	    		"access_level" => 1
	    	);
	    	BizSystem::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
	    	
    	}
    	
    }
}

?>