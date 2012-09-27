<?php 
class AccountService {
	
	protected $m_AccountDO = 'account.do.AccountDO';
	public function GetDefaultAccountId($userId = null)
	{
		if(!$userId)
		{
			$userId = BizSystem::getUserProfile("Id");
		}
		
		$assocRec = BizSystem::getObject("account.do.AccountUserDO")->fetchOne("[user_id]='$userId' AND [default]='1'");
		$accountId = $assocRec['account_id'];
		return $accountId;
	}
	
	public function GetDisplayName($accountId)
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
	
	public function AssocAccountUser($accountId,$userId,$accessLevel='3')//accessLevel = 3 is full control
	{
		$assocRec = array(
			"account_id" => $accountId,
			"user_id"	=>	$userId,
			"access_level" => $accessLevel,
			"default" => '1',
			"status"  => '1'
		);
		return BizSystem::getObject("account.do.AccountUserDO")->insertRecord($assocRec);
	}
	
	public function CreateAccount($rec)
	{
		$rec['code'] = $this->GenAccountCode();
		return BizSystem::getObject($this->m_AccountDO)->insertRecord($rec);
	}
	
	public function ValidateAccountToken($accountCode , $tokenCode)
	{
		return false;
	}
}
?>