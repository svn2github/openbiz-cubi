<?php 

/**
 * 
 * this file not been used yet
 * @author jixian
 *
 */
class AccountPermService 
{
	protected $m_AccountDO 		= "account.do.AccountDO";
	protected $m_AccountUserDO 	= "account.do.AccountUserDO";
	
	public function BuildSQLRule($accountId,$type)
	{
		if(BizSystem::allowUserAccess("data_manage.manage")){
			return " TRUE ";
		}
		
		$accountSvc = BizSystem::getObject("account.lib.AccountService");
		if(!$accountId)
		{
			$accountId = $accountSvc->getDefaultAccountId();
		}
		
		/*
		   <AdminPermission Value="3" text="Full Control"/>
		   <AdminPermission Value="2" text="Read and Write"/>
		   <AdminPermission Value="1" text="Read Only"/>
		   <AdminPermission Value="0" text="No Access"/>
		 */

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
		
		$accountUserDO = BizSystem::getObject($this->m_AccountUserDO);
		$users = $accountUserDO->directfetch("[account_id]='$accountId' AND [access_level]=$perm_limit");
		
		$sql_where = " (";
		foreach($users as $user)
		{
			$userId = $user['user_id'];
			$sql_where .= " [create_by]='$userId' OR ";
		}
		$sql_where .= " FALSE ) ";
		
		return $sql_where;
	}
}
?>