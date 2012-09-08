<?php 
require_once 'iSMS.php';
require_once 'SPDriver.php';
require_once dirname(dirname(__FILE__)).'/dll/c8686/BayouSmsSender.php';


class SPc8686 extends SPDriver implements iSMS 
{
	protected $m_ProviderId = 4;
	protected $m_type = 'c8686';

	protected $m_balance;
		
	public function activeService()
	{
	}
	
	public function send($mobile,$content,$schedule=null)
	{		

		$providerInfo  = $this->_getProviderInfo();
		
		if($schedule=="0000-00-00 00:00:00")
		{
			$schedule='';
		}else{
			$schedule = date('Y-m-d H:i:s',strtotime($schedule));
		}

		$sender=new BayouSmsSender();
		$content= urlEncode(urlEncode(mb_convert_encoding($content, 'gb2312' ,'utf-8')));
		$result=$sender->sendsms($providerInfo['username'],md5($providerInfo['password']),
								$mobile,$content,$schedule);		
		
		if($result['status']==0)
		{				
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","sendMessage: ". $content." Bayou：".$mobile.':'.$result['msg']);
			return false;
		}
		else
		{
			$this->m_balance = $result['balance'];
			$this->HitMessageCounter();
			$this->_log($mobile,$content,$schedule);	
			return true;
		}
			
	}

    public function getMsgBalance()
    {       
    	if($this->m_balance)
    	{
    		$this->updateMsgBalance($this->m_balance);    		
    		return (int)$this->m_balance;
    	}
    	$providerInfo  = $this->_getProviderInfo();
    	$sender=new BayouSmsSender();
    	$balance=$sender->getBalance($providerInfo['username'],md5($providerInfo['password']));
    	$this->m_balance = $balance;		
    	$this->updateMsgBalance($this->m_balance);
    	return (int)$this->m_balance;
	}
    	
  
}



?>