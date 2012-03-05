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
    	
    	$actionList = BizSystem::getObject("system.do.AclActionDO")->directfetch("[module]='collab'");
    	foreach ($actionList as $actionRec){
	    	$actionId = $actionRec["Id"];
	    	
	    	$aclRecord = array(
	    		"role_id" =>  $adminRoleId,
	    		"action_id" => $actionId,
	    		"access_level" => 1
	    	);
	    	BizSystem::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
	    	
		    if(
		    	($actionRec['action']=='manage' && $actionRec['resource']=='collab_announcement') ||
		     	($actionRec['action']=='access' && $actionRec['resource']=='collab_statistics') ||
		     	preg_match("/view_level_/si",$actionRec['action'])
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