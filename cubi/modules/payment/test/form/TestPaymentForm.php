<?php 
class TestPaymentForm extends EasyForm
{
	public $m_PaymentService = "payment.lib.PaymentService";
	
	public function MakePayment()
	{
		$rec= $this->readInputRecord();
		
		$title = $rec['title'];
		$amount = $rec['amount'];
		$providerType = $rec['provider_type'];

		BizSystem::GetService($this->m_PaymentService)->goPayment($amount,$providerType,$title);		
		return true;
	}
}
?>