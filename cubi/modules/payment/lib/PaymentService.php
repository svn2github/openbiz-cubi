<?php 
class PaymentService
{
	protected $m_ProviderDO = "payment.provider.do.ProviderDO";
	
	public function goPayment($amount, $type, $title=null)
	{
		$providerObj = $this->getProviderObj($type);
		$url = $providerObj->getPaymentURL($amount,$title);
		if($url)
		{
			return BizSystem::ClientProxy()->RedirectPage($url);
		}
		return false;
	}
	
	protected function getProviderObj($type)
	{
		$providerRec = BizSystem::getObject($this->m_ProviderDO)->fetchOne("[type]='$type'");
		$driver = $providerRec['driver'];
		$driverFile = MODULE_PATH.'/'.str_replace(".", "/", $driver).'.php';
		$driverName = explode(".", $driver);
		$driverName = $driverName[count($driverName)-1];
		
		if(!$driverFile){return false;}
		require_once $driverFile;
		$obj = new $driverName;
		return $obj;		
	}
}
?>