<?php 
require_once 'PaymentAdapter.php';
require_once dirname(dirname(__FILE__))."/dll/alipay/lib/alipay_service.class.php" ;

class Alipay extends PaymentAdapter
{
	protected $m_ProviderId = 2;
	
	public function __construct()
	{
		parent::__construct();
		$this->m_NotifyURL  .= "&type=alipay";
	}
	
	
	protected function _getConfig()
	{
		$config = $this->_getProviderInfo();
		$alipay_config['partner'] 		= $config['key'];
		$alipay_config['key'] 			= $config['secret'];
		$alipay_config['seller_email']	= $config['account'];
		$alipay_config['return_url']   = $this->m_ReturnURL;
		$alipay_config['notify_url']   = $this->m_NotifyURL;
		$alipay_config['sign_type']    = 'MD5';
		$alipay_config['input_charset']= 'utf-8';
		$alipay_config['transport']    = 'http';
		return $alipay_config;
	}
	
	public function GetPaymentURL($amount,$title=null)
	{
		$alipay_config = $this->_getConfig();
		$out_trade_no = time();
		$body = "test ";
		
		//构造要请求的参数数组
		$parameter = array(
				"service"			=> "create_direct_pay_by_user",
				"payment_type"		=> "1",
				
				"partner"			=> trim($alipay_config['partner']),
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
		        "seller_email"		=> trim($alipay_config['seller_email']),        
		        "return_url"		=> trim($this->m_ReturnURL),
		        "notify_url"		=> trim($this->m_NotifyURL),
				
				"out_trade_no"		=> $out_trade_no,
				"subject"			=> $title,
				"body"				=> $body,
				"total_fee"			=> $amount,
				
				"paymethod"			=> $paymethod,
				"defaultbank"		=> $defaultbank,
				
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				
				"show_url"			=> $show_url,
				"extra_common_param"=> $extra_common_param,
				
				"royalty_type"		=> $royalty_type,
				"royalty_parameters"=> $royalty_parameters
		);
		//构造即时到帐接口
		$alipayService = new AlipayService($alipay_config);
		$html_text = $alipayService->create_direct_pay_by_user($parameter);
		
		var_dump($html_text);
		$url = "http://sss.com.cn";
		return $url;
	}
}
?>