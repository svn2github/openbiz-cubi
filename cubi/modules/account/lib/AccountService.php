<?php 
class AccountService {
	
	protected $m_AccountDO = 'account.do.AccountDO';
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
	
	public function getDisplayName($accountId)
	{
		return BizSystem::getObject($this->m_AccountDO)->fetchById($accountId)->name;		
	}
	
	public function GenAccountCode()
	{
		$code = "ACCT-".date('ym').'-'.rand(111111,999999);
		$rec = BizSystem::getObject($this->m_AccountDO)->fetchOne("[code]='$code'");
		if($rec){
			return $this->GenAccountCode();
		}else{
			return $code;
		}
	}
}
?>