<?php 
require_once 'iSMS.php';
require_once 'SPDriver.php';
require_once dirname(dirname(__FILE__)).'/dll/c8686/BayouSmsSender.php';


class SPc8686 extends SPDriver implements iSMS 
{
	protected $m_ProviderId = 4;
	protected $m_type = 'c8686';

		
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
		$content_log = $content;
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
			$this->HitMessageCounter();
			$this->_log($mobile,$content_log,$schedule);	
			return true;
		}
			
	}

    public function getMsgBalance()
    {       
    	
    	$providerInfo  = $this->_getProviderInfo();
    	$sender=new BayouSmsSender();
    	$balance=$sender->getBalance($providerInfo['username'],md5($providerInfo['password']));
    	$this->updateMsgBalance($balance);
    	return $balance;
	}
    	
  
}



?>