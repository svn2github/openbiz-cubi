<?php 
require_once 'iSMS.php';
require_once 'SPDriver.php';
//SP = Service Provider 18dx

class SPc123 extends SPDriver implements iSMS 
{
	protected $m_ProviderId = 2;
	protected $m_type = 'c123';
	private  $m_url='http://http.c123.com/tx/?';
	private  $m_url_mm='http://http.c123.com/mm/?';
	

 /*
  * http://www.c123.com
	 GET/POST操作格式：

	http://http.c123.com/tx/?uid=用户账号&pwd=MD5位32密码&mobile=号码&content=内容

	接口参数说明:
	参数名	参数字段	参数说明
	uid	用户账号	
	pwd	用户密码	小写32位MD5加密
	time	定时时间	可选项，及时发送时参数无 格式:YYYY-MM-DD HH:MM　如："2010-05-27 12:01" (年-月-日 时:分),发送时间以北京时间为准
	mid	子扩展号	可选项，根据用户账号是否支持扩展
	encode	字符编码	可选项，默认接收数据是GBK编码,如提交的是UTF-8编码字符,需要添加参数 encode=utf8
	mobile	接收号码	同时发送给多个号码时,号码之间用英文半角逗号分隔(,)如:13972827282,13072827282,02185418874
	GET　 方式每次最多可以提交50条号码
	POST　方式每次最多可以提交2000条号码[建议用POST方式提交]
 */
	public function send($mobile,$content,$schedule=null)
	{
		$ProviderInfo = $this->_getProviderInfo(); 
		if(!$ProviderInfo)
		{
			return false;
		}

		$Param=array(
					'uid'=>$ProviderInfo['username'],
					'pwd'=>md5($ProviderInfo['password']),
					'mobile'=>$mobile,
					'content'=>$content,
					'time'=>$schedule,
					'encode'=>'utf8'
				);
		if($schedule=="0000-00-00 00:00:00")
		{
			unset($Param['time']);
		}
		$recinfo=BizSystem::getService("sms.lib.SmsUtilService")->curl($this->m_url,$Param);
		if($recinfo!=100)
		{				
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","sendMessage: ". $content." c123：".$mobile.':'.$recinfo);
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
    	$ProviderInfo = $this->_getProviderInfo();
		if(!$ProviderInfo)
		{
			return false;
		}
		$Param=array(
					'uid'=>$ProviderInfo['username'],
					'pwd'=>strtoupper(md5($ProviderInfo['password'])),
					'encode'=>'utf8'
				);
		//$url=$this->m_url_mm.http_build_query($Param);
		$recinfo=BizSystem::getService("sms.lib.SmsUtilService")->curl($this->m_url_mm,$Param);
		$recArr=explode('||',$recinfo);
		if($recArr[0]!=100)
		{
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","getSentMessageCount c123: ".$recinfo);
			return false;
		}
		else
		{
			$balance = $recArr[1];
			$this->updateMsgBalance($balance);
			return $balance;
		}
	}
    	
  
}
?>