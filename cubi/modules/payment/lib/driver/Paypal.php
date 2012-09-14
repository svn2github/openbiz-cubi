<?php 
require_once 'PaymentAdapter.php';
require_once dirname(dirname(__FILE__))."/dll/paypal/paypal_class.php" ;


class Paypal extends PaymentAdapter
{
	protected $m_ProviderId = 3;
	protected $m_Type = 'paypal';
	
	protected $m_CurrencyCode = 'CNY';
	
	public function GetPaymentURL($orderId, $amount, 
								  $title=null,$customData=null)
	{
		
		$config = $this->_getProviderInfo();
		
	  	$paypal = new paypal_class();
		$paypal->add_field("cmd", 			"_xclick");
		$paypal->add_field("business", 		$config['account']);
		$paypal->add_field("return", 		$this->m_ReturnURL);
		$paypal->add_field("cancel_return", $this->m_CancelURL);
		$paypal->add_field("quantity",		1);
		$paypal->add_field("amount",		$amount);
		$paypal->add_field("item_name",		$title);
		$paypal->add_field("item_number",	$orderId);
		$paypal->add_field("undefined_quantity",0);
		$paypal->add_field("no_shipping",	1);
		$paypal->add_field("rm",			2);
		$paypal->add_field("custom",		serialize($customData));
		$paypal->add_field("charset",		'utf-8');
		$paypal->add_field("currency_code",	$this->m_CurrencyCode);
		
		$url = $paypal->build_param_url();
		return $url;
	}							  
}
?>