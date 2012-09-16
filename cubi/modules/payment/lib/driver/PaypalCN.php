<?php 
require_once 'Paypal.php';

class PaypalCN extends Paypal
{
	protected $m_ProviderId = 1;
	protected $m_Type = 'paypalcn';
	protected $m_CurrencyCode = 'CNY';
}
?>