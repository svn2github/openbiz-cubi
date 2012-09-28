<?php 
require_once 'iSMS.php';
require_once 'SPDriver.php';
require_once dirname(dirname(__FILE__)).'/dll/emay/nusoaplib/nusoap.php';


class SPtclk extends SPDriver implements iSMS 
{
	protected $m_ProviderId = 5;
	protected $m_type = 'tclk';

	protected $m_URL = "http://inolink.com/WS/linkWS.asmx/";
		
	public function activeService()
	{
		return true;
		$providerInfo = $this->_getProviderInfo();
		$CorpID = $providerInfo['username'];
		$Pwd = $providerInfo['password'];
		
		$CropName 	= urlencode(BizSystem::GetUserProfile("profile_company"));
		$LinkMan 	= urlencode(BizSystem::GetUserProfile("profile_display_name"));
		$Tel 		= urlencode(BizSystem::GetUserProfile("profile_phone"));
		$Mobile 	= urlencode(BizSystem::GetUserProfile("profile_mobile"));
		$Email		= urlencode(BizSystem::GetUserProfile("email"));
				
		//$url = $this->m_URL."Reg?CorpID=$CorpID&Pwd=$Pwd&CorpName=$CorpName&LinkMan=$LinkMan&Tel=$Tel&Mobile=$Mobile&Email=$Email";
		//$result = file_get_contents($url);

		if(0 == $result)
		{
			return true;
		}
		else
		{
		    return false;
		}
		
	}
	
	public function send($mobile,$content,$schedule=null)
	{		

		$providerInfo  = $this->_getProviderInfo();
		$CorpID = $providerInfo['username'];
		$Pwd = $providerInfo['password'];
		
		if($schedule=="0000-00-00 00:00:00")
		{
			$schedule='';
		}else{
			$schedule = date('YmdHis',strtotime($schedule));
		}
		$mobile_log = $mobile;
		$content_log = $content;
		
		$mobile  = urlencode($mobile);
		$content = urlencode(iconv("UTF-8","GBK",$content));
		
		$url = $this->m_URL."BatchSend?CorpID=$CorpID&Pwd=$Pwd&Mobile=$mobile&Content=$content&Cell=&SendTime=$schedule";
		$result = file_get_contents($url);	

		preg_match("/\">(.*?)<\/int/si", $result,$match);
		$result = (int)$match[1];
				
		if($result<0)
		{				
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","sendMessage: ". $content." TCLK：".$mobile.':'.$result['msg']);
			return false;
		}
		else
		{			
			$this->HitMessageCounter();
			$this->_log($mobile_log,$content_log,$schedule);	
			return true;
		}
			
	}

    public function getMsgBalance()
    {       
    	$providerInfo  = $this->_getProviderInfo();
		$CorpID = $providerInfo['username'];
		$Pwd = $providerInfo['password'];
		
		$url = $this->m_URL."SelSum?CorpID=$CorpID&Pwd=$Pwd";
		$result = file_get_contents($url);
			
		preg_match("/\">(.*?)<\/int/si", $result,$match);
		$balance = (int)$match[1];
    	$this->updateMsgBalance($balance);
		return $balance;
	}
    	
  
}



?>