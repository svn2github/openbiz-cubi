<?php 
class AccountService {
	
	public function getDefaultAccountId($userId = null)
	{
		if(!$userId)
		{
			$userId = BizSystem::getUserProfile("Id");
		}
		
		$assocRec = BizSystem::getObject("account.do.AccountUserDO")->fetchOne("[user_id]='$userId' AND [default]='1'");
		$accountId = $assocRec['account_id'];
		return $accountId;
	}
}
?>