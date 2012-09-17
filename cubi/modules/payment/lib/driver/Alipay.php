<?php 
require_once 'PaymentAdapter.php';
require_once dirname(dirname(__FILE__))."/dll/alipay/lib/alipay_service.class.php" ;
require_once dirname(dirname(__FILE__))."/dll/alipay/lib/alipay_submit.class.php" ;
require_once dirname(dirname(__FILE__))."/dll/alipay/lib/alipay_notify.class.php" ;

class Alipay extends PaymentAdapter
{
	protected $m_ProviderId = 2;
	protected $m_Type = 'alipay';
	
	protected $m_APIURL = 'https://mapi.alipay.com/gateway.do?';
	
	
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
	
	public function GetPaymentURL($orderId, $amount, 
								  $title=null,$customData=null)
	{
		$alipay_config = $this->_getConfig();
		
		if($customData)
		{
			$customData = json_encode($customData);
		}
		
		//构造要请求的参数数组
		$parameter = array(
				"service"			=> "create_direct_pay_by_user",
				"payment_type"		=> "1",
				
				"partner"			=> trim($alipay_config['partner']),
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
		        "seller_email"		=> trim($alipay_config['seller_email']),        
		        "return_url"		=> trim($this->m_ReturnURL),
		        "notify_url"		=> trim($this->m_NotifyURL),
				
				"out_trade_no"		=> $orderId,
				"subject"			=> $title,
				"total_fee"			=> $amount,
				
				"paymethod"			=> $paymethod,
				"defaultbank"		=> $defaultbank,
				
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				
				"show_url"			=> SITE_URL,
				"extra_common_param"=> $customData,
				
				"royalty_type"		=> $royalty_type,
				"royalty_parameters"=> $royalty_parameters
		);
		//构造即时到帐接口
		$alipaySubmit = new AlipaySubmit();
		$url = $this->m_APIURL. $alipaySubmit->buildRequestParaToString($parameter,$alipay_config);

		return $url;
	}
	
	public function GetReturnData(){
		$data = array();
		$data['buyer_account'] 	= $_REQUEST['buyer_email'];
		$data['buyer_id'] 		= $_REQUEST['buyer_id'];
		$data['order_id'] 		= $_REQUEST['out_trade_no'];
		$data['trans_id'] 		= $_REQUEST['trade_no'];
		$data['txn_id'] 		= $_REQUEST['trade_no'];
		$data['subject'] 		= $_REQUEST['subject'];
		$data['amount'] 		= $_REQUEST['total_fee'];
		$data['status'] 		= $_REQUEST['trade_status'];
		$data['custom'] 		= $_REQUEST['extra_common_param'];
		return $data;		
	}
	
	public function ValidateNotification($txn_id=null)
	{
		parent::ValidateNotification($txn_id);
		$alipay_config = $this->_getConfig();
		$alipayNotify = new AlipayNotify($alipay_config);		
		return $alipayNotify->getResponse($txn_id);
	}

}
?>