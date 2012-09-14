<?php 
class TestPaymentForm extends EasyForm
{
	public $m_PaymentService = "payment.lib.PaymentService";
	
	public function MakePayment()
	{
		$rec= $this->readInputRecord();
		$orderId = $rec['order_id'];
		$title = $rec['title'];
		$amount = $rec['amount'];
		$providerType = $rec['provider_type'];

		BizSystem::GetService($this->m_PaymentService)->goPayment($orderId,$amount,$providerType,$title);		
		return true;
	}
	
	public function getOrderID()
	{
		$orderId = "TORD-".date("ym").'-'.rand(000000,999999);
		return $orderId;
	}
}
?>