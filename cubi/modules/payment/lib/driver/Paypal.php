<?php 
require_once 'PaymentAdapter.php';

class Paypal extends PaymentAdapter
{
	protected $m_ProviderId = 3;
	
	public function __construct()
	{
		$this->m_NotifyURL  .= "&type=paypal";
	}
}
?>