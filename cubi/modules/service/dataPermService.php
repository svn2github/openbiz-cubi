<?php 
if(!defined('GROUP_DATA_SHARE')){ define('GROUP_DATA_SHARE','0'); }

class dataPermService
{
	
	public function CheckDataOwner($rec)
	{
		if(BizSystem::allowUserAccess("data_manage.manage")){
			return true;
		}
		$user_id = BizSystem::GetUserProfile('Id');
		if($rec['owner_id'])
		{
			if($rec['create_by']==$user_id ||
				$rec['owner_id']==$user_id ){
				return true;
			}
		}
		else{
			if($rec['create_by']==$user_id){
				return true;
			}
		}
		return false;
	}
	public function CheckDataPerm($rec,$permCode)
	{
		if(BizSystem::allowUserAccess("data_manage.manage")){
			return true;
		}
		if($rec==null)
		{
			return true;
		}
		$user_id = BizSystem::GetUserProfile('Id');
		$user_groups = BizSystem::GetUserProfile('groups');
		$data_owner = $rec['create_by'];
		$data_group = $rec['group_id'];
		$group_perm = $rec['group_perm'];
		$other_perm = $rec['other_perm'];

		if($rec['owner_id']!=null){
			if($user_id==$rec['owner_id']){
				return true;
			}			
		}
		if($user_id == $data_owner)
		{
			return true;
		}else{
			if(GROUP_DATA_SHARE==0)
			{
				return false;
			}
		}		
		
		
				
		if($other_perm >= $permCode)
		{
			return true;
		}
		
		if($group_perm >= $permCode)
		{
			foreach($user_groups as $group_id)
			{
				if($group_id == $data_group)
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function BuildSQLRule($type,$hasOwnerField=false)
	{
		if(BizSystem::allowUserAccess("data_manage.manage")){
			return "";
		}
		$sql_where = null;
		$user_id = BizSystem::GetUserProfile('Id');
		$user_groups = BizSystem::GetUserProfile('groups');
		
		if($hasOwnerField){
			$sql_where = " ( ([create_by]='$user_id' OR [owner_id]='$user_id') ";
		}else{
			$sql_where = " ( [create_by]='$user_id' ";
		}
		
		if(GROUP_DATA_SHARE==0)
		{
			return $sql_where." ) ";
		}
		
		switch($type)
		{
			default:
			case 'select':
				$perm_limit = ">=1"; 				
				break;
			case 'update':
				$perm_limit = ">=2";
				break;
			case 'delete':
				$perm_limit = ">=3";
				break;
		}
				
		if(count($user_groups)){
			$sql_where .= " OR ( [group_perm] $perm_limit AND (";				
			foreach($user_groups as $group_id)
			{
				$sql_where .= " [group_id] = '$group_id' OR ";
			}
			$sql_where .= " FALSE ) )";
		}
		$sql_where .= " OR [other_perm] $perm_limit  )";
		return $sql_where;
	}
	
	
	public function getReadableUserList($recArr)
	{
		$recId 		= $recArr['Id'];
		$creatorId 	= $recArr['create_by'];
		$ownerId 	= $recArr['owner_id'];
		$groupId 	= $recArr['group_id'];
		$groupPerm 	= $recArr['group_perm'];
		$otherPerm 	= $recArr['other_perm'];
		
	
		$userListArr = array();
		$userListArr[$creatorId] = $creatorId;
		
		if($ownerId	!= $creatorId)
		{
			$userListArr[$ownerId] = $ownerId;
		}
			
		//test if changes for group level visiable
		if($groupPerm >=1)
		{
			$userList = $this->_getGroupUserList($groupId);
			foreach($userList as $user_id)
			{
				$userListArr[$user_id] = $user_id;
			}				
		}
		
		//test if changes for other group level visiable
		if($otherPerm >=1)
		{				
			$groupList = $this->_getGroupList();
			foreach($groupList as $group_id){
				if($groupId==$group_id)
				{
					continue;
				}					
				$userList = $this->_getGroupUserList($group_id);
				foreach($userList as $user_id)
				{
					$userListArr[$user_id] = $user_id;
				}				
			}
		}
		return $userListArr;
		
	}
	
	public function getEditableUserList($recArr)
	{
		$recId 		= $recArr['Id'];
		$creatorId 	= $recArr['create_by'];
		$ownerId 	= $recArr['owner_id'];
		$groupId 	= $recArr['group_id'];
		$groupPerm 	= $recArr['group_perm'];
		$otherPerm 	= $recArr['other_perm'];
		
	
		$userListArr = array();
		$userListArr[$creatorId] = $creatorId;
		
		if($ownerId	!= $creatorId)
		{
			$userListArr[$ownerId] = $ownerId;
		}
			
		//test if changes for group level visiable
		if($groupPerm >=2)
		{
			$userList = $this->_getGroupUserList($groupId);
			foreach($userList as $user_id)
			{
				$userListArr[$user_id] = $user_id;
			}				
		}
		
		//test if changes for other group level visiable
		if($otherPerm >=2)
		{				
			$groupList = $this->_getGroupList();
			foreach($groupList as $group_id){
				if($groupId==$group_id)
				{
					continue;
				}					
				$userList = $this->_getGroupUserList($group_id);
				foreach($userList as $user_id)
				{
					$userListArr[$user_id] = $user_id;
				}				
			}
		}
		return $userListArr;
		
	}
	protected function _getGroupList(){
		$rs = BizSystem::getObject("system.do.GroupDO")->directFetch("");
		$group_ids = array();
		foreach($rs as $group){
			$group_ids[]=$group['Id'];
		}
		return $group_ids;
	}
	
	protected function _getGroupUserList($group_id){
		$rs = BizSystem::getObject("system.do.UserGroupDO")->directFetch("[group_id]='$group_id'");
		$user_ids = array();
		foreach($rs as $user){
			$user_ids[]=$user['user_id'];
		}
		return $user_ids;
	}		
}
?>