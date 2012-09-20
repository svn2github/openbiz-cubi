<?php 
require_once 'PaymentAdapter.php';

class ChinaBank extends PaymentAdapter
{
	protected $m_ProviderId = 4;
	protected $m_Type = 'chinabank';
	
	protected $m_CurrencyCode = 'CNY';
	
	public function GetPaymentURL($orderId, $amount, 
								  $title=null,$customData=null)
	{
		$url  = "https://pay3.chinabank.com.cn/PayGate?";
		
		$config = $this->_getProviderInfo();
		
		if($customData)
		{
			$customData = json_encode($customData);
		}
		
		$paramArr = array(
			"key"		=> $config['secret'],	
			"v_mid"		=> $config['account'],
			"v_url"		=> $this->m_ReturnURL,			
			"v_oid"		=> $orderId,
			"v_amount"	=> $amount,
			"v_moneytype" => $this->m_CurrencyCode,
			"remark1"	=> base64_encode($customData),					
		); 
		
		$text = $paramArr['v_amount'].$paramArr['v_moneytype'].$paramArr['v_oid'].$paramArr['v_mid'].$paramArr['v_url'].$paramArr['key'];
    	$paramArr['v_md5info'] = strtoupper(md5($text)); 
    
    	foreach($paramArr as $key=>$value)
    	{
    		$url .= "$key=$value&";
    	}					
		return $url;
	}

	public function GetReturnData(){
		$data = array();		
		$this->_convertRequestData();
		
		$data['buyer_account'] 	= trim($_REQUEST['v_pmode']);
		$data['buyer_id']	 	= trim($_REQUEST['v_pmode']);
		$data['order_id'] 		= trim($_REQUEST['v_oid']);
		$data['trans_id'] 		= trim($_REQUEST['v_idx']);
		$data['txn_id'] 		= trim($_REQUEST['v_idx']);
		$data['subject'] 		= trim($_REQUEST['v_pmode']);
		$data['amount'] 		= trim($_REQUEST['v_amount']);
		$data['status'] 		= trim($_REQUEST['v_pstatus']);
		$data['custom'] 		= base64_decode(trim($_REQUEST['remark1']));
		
		return $data;		
	}
	
	protected function _convertRequestData()
	{
		if($_REQUEST['converted_utf8']!=1)
		{
			foreach($_REQUEST as $key=>$value)
			{
				$_REQUEST[$key] = iconv("GB2312","UTF-8",trim($value));
			}
			$_REQUEST['converted_utf8']=1;
		}
	}
	
	public function ValidateNotification($txn_id=null)
	{
		parent::ValidateNotification($txn_id);
		$config = $this->_getProviderInfo();
		$v_md5str = trim($_REQUEST['v_md5str']);
		$md5str = strtoupper(md5(trim($_REQUEST['v_oid']).trim($_REQUEST['v_pstatus']).trim($_REQUEST['v_amount']).trim($_REQUEST['v_moneytype']).$config['secret']) );
		$result = true;
		return $result;	
	}	
}
?>