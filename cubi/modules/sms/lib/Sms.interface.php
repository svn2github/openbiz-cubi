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
 * @version   $Id: oauthService.php 3371 2012-05-31 06:17:21Z rockyswen@gmail.com $
 */
interface iSmsProvider
{
    public function send($ProviderInfo,$mobile,$content,$time);
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
	public $m_url='http://18dx.cn/API/Services.aspx?';
	public function send($ProviderInfo,$mobile,$content,$time=null){
	
		$Param=array(
					'action'=>'msgsend',
					'user'=>$ProviderInfo['username'],
					'hashcode'=>strtoupper(md5($ProviderInfo['password'])),
					'mobile'=>$mobile,
					'content'=>$content,
					'msgid'=>0,
					'encode'=>'UTF-8'
				);

		$url=$this->m_url.http_build_query($Param); 
		$recinfo=getHttpResponse($url);
		//$recinfo='1&errid=1&fee=1&balance=9&fails=&msgid=634805826699791739&msg=发送成功';
		parse_str($recinfo,$recArr);
		if($recArr['errid']!=1)
		{	
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND", $recArr['msg'],$mobile.':'.$recinfo);
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
			return $errorInfo;
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
 //http://www.c123.com
class ProviderB implements iSmsProvider
{
	public function send($ProviderInfo,$mobile,$content,$time=null){
		return true;
	}
	public function getSentMessageCount($ProviderInfo){
		return true;
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