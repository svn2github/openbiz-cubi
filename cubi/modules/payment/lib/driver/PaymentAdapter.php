<?php 
require_once 'iPayment.php';
class PaymentAdapter implements iPayment
{
	protected $m_ProviderId;
	protected $m_ReturnURL = "";
	protected $m_NotifyURL = "";	
	
	protected $m_ProviderDO = "payment.provider.do.ProviderDO";
	
	protected function _getProviderInfo()
	{
		$ProviderDO = BizSystem::getObject($this->m_ProviderDO);
		$recObj=$ProviderDO->fetchOne("[Id]={$this->m_ProviderId}");
		$recArr=array();
		if($recObj)
		{
			$recArr=$recObj->toArray();
		}
		return $recArr;
	}	
	
	public function __construct()
	{
		$this->m_NotifyURL  = SITE_URL.'ws.php/payment/callback/?method=verify';
		$this->m_ReturnURL  = SITE_URL.APP_INDEX.'/payment/payment_finished';
	}
	
    public function GetPaymentURL($amount,$title=null){}

    public function ValidateNotification($txn_id){}    
    
    public function log(){}	
}
?>