<?php 
require_once 'PaymentAdapter.php';
require_once dirname(dirname(__FILE__))."/dll/paypal/paypal_class.php" ;


class Paypal extends PaymentAdapter
{
	protected $m_ProviderId = 3;
	protected $m_Type = 'paypal';
	
	protected $m_CurrencyCode = 'USD';
	
	public function GetPaymentURL($orderId, $amount, 
								  $title=null,$customData=null)
	{
		
		$config = $this->_getProviderInfo();
		
		if($customData)
		{
			$customData = json_encode($customData);
		}
		
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
		$paypal->add_field("no_note",		1);
		$paypal->add_field("rm",			2);
		$paypal->add_field("custom",		$customData);
		$paypal->add_field("charset",		'utf-8');
		$paypal->add_field("currency_code",	$this->m_CurrencyCode);
		
		$url = $paypal->build_param_url();

		return $url;
	}

	public function GetReturnData(){
		$data = array();		
		
		$data['buyer_account'] 	= $_REQUEST['payer_email'];
		$data['buyer_id']	 	= $_REQUEST['payer_id'];
		$data['order_id'] 		= $_REQUEST['item_number'];
		$data['trans_id'] 		= $_REQUEST['txn_id'];
		$data['txn_id'] 		= $_REQUEST['txn_id'];
		$data['subject'] 		= $_REQUEST['item_name'];
		$data['amount'] 		= $_REQUEST['mc_gross'];
		$data['status'] 		= $_REQUEST['payment_status'];
		$data['custom'] 		= $_REQUEST['custom'];
		
		return $data;		
	}
	
	public function ValidateNotification($txn_id=null)
	{
		parent::ValidateNotification($txn_id);
		$paypal = new paypal_class();
		$paypal->paypal_mail = $config['account'];
		$result = $paypal->validate_ipn();		
		return $result;	
	}	
}
?>