<?php 
require_once 'iPayment.php';
class PaymentAdapter implements iPayment
{
	protected $m_ProviderId;
	protected $m_ReturnURL = "";
	protected $m_CancelURL = "";
	protected $m_NotifyURL = "";		
	protected $m_Type = '';
		
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
		$this->m_NotifyURL  = SITE_URL.'ws.php/payment/callback/verify/';
		$this->m_ReturnURL  = SITE_URL.APP_INDEX.'/payment/payment_finished/type_'.$this->m_Type.'/';
		$this->m_CancelURL  = SITE_URL.APP_INDEX.'/payment/payment_cancelled/type_'.$this->m_Type.'/';
	}
	
    public function GetPaymentURL($orderId, $amount,  $title=null,$customData=null){}

    public function ValidateNotification($txn_id){}    
    
	public function GetReturnData(){}
	
    public function log(){}	
    
}
?>