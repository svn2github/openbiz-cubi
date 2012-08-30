<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: Sms.interface.php 3371 2012-08-30 06:17:21Z fsliit@gmail.com $
 */
interface iSmsProvider
{	
	/**
	 * 发送短信
	 *
	 * @access   public
	 * @param	$ProviderInfo   短信提供商信息包涵用户和密码
	 * @param	$mobile   手机号码，多个可以用点号分开
	 * $param	$content 短信内容，最多支持250个字，67个字按一条短信计费
	 * $param	$time  定时时间 可选项，及时发送时参数无 格式:YYYY-MM-DD HH:MM
	 * @return   true/false
	 */
    public function send($ProviderInfo,$mobile,$content,$time);
	
	/**
	 * 获取剩余的短信数量
	 *
	 * @access   public
	 * @param	$ProviderInfo   短信提供商信息包涵用户和密码
	 * @return   true/false
	 */
    public function getSentMessageCount($ProviderInfo);
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
class ProviderA  implements iSmsProvider
{
	private  $m_url='http://18dx.cn/API/Services.aspx?';
	public function send($ProviderInfo,$mobile,$content,$time=''){
	
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

		$url=$this->m_url.http_build_query($Param); 
		$recinfo=getHttpResponse($url);
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
	public function getSentMessageCount($ProviderInfo){
		$Param=array(
					'action'=>'getbalance',
					'user'=>$ProviderInfo['username'],
					'hashcode'=>strtoupper(md5($ProviderInfo['password'])),
					'hashcode'=>$ProviderInfo['password']
				);
		$url=$this->m_url.http_build_query($Param);
		$info=getHttpResponse($url);
		$errorInfo=$this->getMsg($info);
		if($errorInfo)
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR",'getSentMessageCount','18dx:'.$errorInfo);
			return false;
		}
		else
		{
			return $info;
		}
	}
	private function getMsg($recinfo){
		$msg=array
		(
			"1"=>"全部成功",
			"2"=>"部分成功",
			"0"=>"系统原因失败",
			"-1"=>"用户不存在或已禁用",
			"-2"=>"hashcode或密码不正确",
			"-3"=>"接收号码不正确",
			"-4"=>"内容为空或超长（不超过250字）",
			"-5"=>"个性短信内容与号码长度不一致",
			"-6"=>"内容含非法字符",
			"-7"=>"帐户余额不足",
			"-8"=>"提交过于频繁(超过1分钟的最大提交批次限定,1分钟内最多允许提交20个批次)",
			"-9"=>"小批次短信已达到最大限定值",
			"-10"=>"未添加通道企业签名"
		);
		return $msg[$recinfo];
	}
}
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
class ProviderB implements iSmsProvider
{
	private  $m_url='http://http.c123.com/tx/?';
	private  $m_url_mm='http://http.c123.com/mm/?';
	public function send($ProviderInfo,$mobile,$content,$time=''){
		$Param=array(
					'uid'=>$ProviderInfo['username'],
					'pwd'=>strtoupper(md5($ProviderInfo['password'])),
					'mobile'=>$mobile,
					'content'=>$content,
					'time'=>$time,
					'encode'=>'utf8'
				);
 
		$url=$this->m_url.http_build_query($Param); 
		
		$recinfo=getHttpResponse($url);
		
		if($recinfo!=100)
		{	
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", 'send','c123：'.$mobile.':'.$recinfo);
			return false;
		}
		else
		{
			return true;
		}
	}
	public function getSentMessageCount($ProviderInfo){
		$Param=array(
					'uid'=>$ProviderInfo['username'],
					'pwd'=>strtoupper(md5($ProviderInfo['password'])),
					'encode'=>'utf8'
				);
				$url=$this->m_url_mm.http_build_query($Param);
				$recinfo=getHttpResponse($url);
				$recArr=explode('||',$recinfo);
				if($recArr[0]!=100)
				{
					$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
					$eventlog->log("SMSSEND_ERROR", 'getSentMessageCount',$recinfo);
					return false;
				}
				else
				{
					return $recArr[1];
				}
	}
}
function getHttpResponse($url)
{
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		return $file_contents;
}
?>