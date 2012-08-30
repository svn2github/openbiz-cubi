<?php 
require_once 'iSMS.php';
require_once MODULE_PATH.'/sms/lib/utilService.php';
//SP = Service Provider 18dx

class SP18dx  extends utilService implements iSMS 
{
	protected $m_ProviderId = 1;
	
	protected function _getProviderInfo()
	{
		$SmsProviderDO = BizSystem::getObject($this->m_ProviderDo);
		$recObj=$SmsProviderDO->fetchOne("[Id]={$this->m_ProviderId}");
		$recArr=array();
		if($recObj)
		{
			$recArr=$recObj->toArray();
		}
		return $recArr;
	}
 /*
	官方网：www.18dx.cn
	参数变量	 说明
	发送接口地址Url	 http://18dx.cn/API/Services.aspx
	action	 操作类型
	user	 本站用户名（如您无本站用户名请先联系客服开通）
	hashcode	 用户密码(明文或MD5加密)
	mobile	 目的手机号码（多个手机号请用半角逗号或封号隔开）
	content	 短信内容，最多支持250个字，67个字按一条短信计费
	time	 短信定时发送时间,可以传空值,为空则视为立即发送,格式:yyyy-MM-dd HH:mm:ss
	msgid	 短信批次的唯一ID,长整型,可以传空值,若不传空值请做好唯一判断
	发送成功后返回字符串中,将返回系统自动给出的批次ID,
	该ID可以与手机号码一起用于配置短信报告与上行短信记录
	encode	 编码,为空或不加该参数,默认为UTF-8, 可以传: GB2312 ,gbk 等
	多个手机号请用半角“,”隔开，如：13888888886,13888888887,1388888888 。
	短信内容支持长短信，最多250个字，67个字按一条短信计费。
*/
	public function send($mobile,$content)
	{
		$ProviderInfo = $this->_getProviderInfo();
		$Param=array(
					'action'=>'msgsend',
					'user'=>$ProviderInfo['username'],
					'hashcode'=>strtoupper(md5($ProviderInfo['password'])),
					'mobile'=>$mobile,
					'content'=>$content,
					'msgid'=>0,
					'time'=>$time,
					'encode'=>'UTF-8'
				);

		//$url=$this->m_url.http_build_query($Param); 
		$recinfo=$this->curl($this->m_url,$Param);
		//$recinfo='1&errid=1&fee=1&balance=9&fails=&msgid=634805826699791739&msg=发送成功';
		parse_str($recinfo,$recArr);
		if($recArr['errid']!=1)
		{	
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", $recArr['msg'],'18dx:'.$mobile.':'.$recinfo);
			return false;
		}
		else
		{
			return $recArr;
		}	
	}

    public function getSentCount()
    {
    	$ProviderInfo = $this->_getProviderInfo();
		$Param=array(
					'action'=>'getbalance',
					'user'=>$ProviderInfo['username'],
					'hashcode'=>strtoupper(md5($ProviderInfo['password'])),
					'hashcode'=>$ProviderInfo['password']
				);
		//$url=$this->m_url.http_build_query($Param);
		$recinfo=$this->curl($this->m_url,$Param);
		$errorInfo=$this->getMsg($recinfo);
		if($errorInfo)
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR",'getSentMessageCount','18dx:'.$errorInfo);
			return false;
		}
		else
		{
			return $recinfo;
		}
    }
}
?>