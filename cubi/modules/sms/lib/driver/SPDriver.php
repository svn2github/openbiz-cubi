<?php 
require_once 'iSMS.php';
//SP = Service Provider 18dx

class SPDriver implements iSMS 
{
	protected $m_ProviderDo = 'sms.provider.do.ProviderDO';	
	
	public function send($mobile,$content){}
	
	public function getMsgBalance(){}

	public function updateMsgBalance($balance)
	{
		$providerRec=BizSystem::getObject($this->m_ProviderDo)->fetchOne("[Id]={$this->m_ProviderId}");
		$providerRec['msg_balance']=(int)$balance;
		$providerRec->save();
		return $this;
	}	
	
	public function HitMessageCounter()
	{		
		$providerRec=BizSystem::getObject($this->m_ProviderDo)->fetchOne("[Id]={$this->m_ProviderId}");
		$providerRec['msg_send_counter']+=1;
		$providerRec['msg_last_sendtime']=date("Y-m-d H:i:s");
		$providerRec->save();
		$this->getMsgBalance();
		return $this;
	}
	
	public function getMessageCounter()
	{
		$providerRec=BizSystem::getObject($this->m_ProviderDo)->fetchOne("[Id]={$this->m_ProviderId}");		
		return $providerRec['msg_send_counter'];
	}
	
	protected  function _getProviderInfo()
	{
		$SmsProviderDO = BizSystem::getObject($this->m_ProviderDo);
		$recObj=$SmsProviderDO->fetchOne("[Id]={$this->m_ProviderId}");
		$recArr=array();
		if($recObj)
		{
			$recArr=$recObj->toArray();
		}
		return $recArr;
	}	
	
}