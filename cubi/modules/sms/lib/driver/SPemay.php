<?php 
require_once 'iSMS.php';
require_once 'SPDriver.php';
require_once dirname(dirname(__FILE__)).'/dll/emay/include/EmayClient.php';

class SPemay extends SPDriver implements iSMS 
{
	protected $m_ProviderId = 3;
	protected $m_type = 'emay';
	protected $m_WebsvcURL	=	'http://sdkhttp.eucp.b2m.cn/sdk/SDKService?wsdl';
	protected $m_ClientObj;
	
	
	protected function getClientObj()
	{
		if($this->m_ClientObj)
		{
			return $this->m_ClientObj;
		}		
		$ProviderInfo = $this->_getProviderInfo(); 
		if(!$ProviderInfo)
		{
			return false;
		}
		$serialNumber = $ProviderInfo['username'];
		$password = $ProviderInfo['password'];
		$sessionKey = $ProviderInfo['username'];
		
		$connectTimeOut = 2;
		$readTimeOut = 10;
		
		$proxyhost = false;
		$proxyport = false;
		$proxyusername = false;
		$proxypassword = false; 
		
		$client = new EmayClient($this->m_WebsvcURL,$serialNumber,$password,$sessionKey,
							$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
		$client->setOutgoingEncoding("UTF-8");
		$this->m_ClientObj = $client;
		return $this->m_ClientObj;
	}
		
	public function activeService()
	{
		$ProviderInfo = $this->_getProviderInfo(); 
		if(!$ProviderInfo)
		{
			return false;
		}
		$result = $this->getClientObj()->login($ProviderInfo['username']);
		$this->getMsgBalance();
		return $result;
	}
	
	public function send($mobile,$content,$schedule=null)
	{		
		if($schedule=="0000-00-00 00:00:00")
		{
			$schedule='';
		}else{
			$schedule = date('YmdHis',strtotime($schedule));
		}

		$result = $this->getClientObj()->sendSMS(array($mobile),$content,$schedule,'','UTF-8');
		
		if($result)
		{				
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","sendMessage: ". $content." emay：".$mobile.':'.$result);
			return false;
		}
		else
		{
			$this->HitMessageCounter();
			$this->_log($mobile,$content,$schedule);	
			return true;
		}
			
	}

    public function getMsgBalance()
    {
    	$balance = $this->getClientObj()->getBalance();
    	$unitPrice = $this->getClientObj()->getEachFee();
    	$count = (int)($balance/$unitPrice);
    	$this->updateMsgBalance($count);
		return $count;
	}
    	
  
}



?>