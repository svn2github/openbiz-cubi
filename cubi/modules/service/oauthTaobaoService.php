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
 * @version   $Id$
 */


/**
 *  实现对淘宝API的获取
 *
 * @package service.oauthTaobaoService
 * @author  shenglong feng email：fsliit@gmail.com
 * @copyright Copyright (c) 2012 
 * @access public
 **/
/*
第三方用户登录实现
一、配置oauthService.xml文件
	这里以淘宝API为例：具体KEY和Secret请到OPEN.Taobao.COM进行申请
	<Provider   Name="Taobao" 
	DisplayName="Taobao API" 
	Key=""
	Secret=""
	URL="http://container.open.taobao.com/container" 
	Class="oauthTaobaoService"
	/>
二、调用地址
	参数说明
	type 第三方类型例:taobao、qq等
	service 执行的服务名

登录第三方平台地址：
	/cubi/oauth_callback_handler.php?type=Taobao&service=login

回调地址：
	/cubi/oauth_callback_handler.php?type=Taobao&service=check

三、获取第三方返回的密钥信息
	$obj = BizSystem::getService("service.oauthTaobaoServic");
	$obj->GetUserOauth();

范例：
	实现获取当前用户的淘宝信息
	$obj = BizSystem::getService("service.oauthTaobaoServic");
	$top_session=$obj->GetUserOauth();
	$obj->Api->method = 'taobao.user.get';
	$obj->Api->session =$top_session['oauth_oauth_secret'];
	$obj->Api->fields = 'nick,sex,buyer_credit,seller_credit,location,created';
	$userinfo=$obj->Api->Send('get','xml')->getArrayData();
*/
require_once "oauthService.php";
require_once(dirname(__FILE__).'/taoapi/Taoapi.php');
class oauthTaobaoService extends oauthService
{
	protected $m_Type='Taobao';
	protected $m_Oauth='';
	protected $m_Key='';
	protected $m_Secret='';
	function __construct(&$xmlArr)
    { 
		$this->App($xmlArr); 
		
    }
    function App(&$xmlArr)
    { 
		parent::__construct($xmlArr);
		$ProviderData=$this->getProviderData();
		$this->m_Key=$ProviderData['KEY'];
		$this->m_Secret=$ProviderData['SECRET'];
		$this->Taoapi_Config = Taoapi_Config::Init();
		$this->Taoapi_Config->setCharset('UTF-8');
		$this->Taoapi_Config->setAppKey($this->m_Key);
		$this->Taoapi_Config->setAppSecret($this->m_Secret);
		$this->ApiConfig = $this->Taoapi_Config->getConfig();
		$this->Api=new Taoapi();	
    }
	function check(){
		$app_secret = current($this->Api->ApiConfig->AppKey); 
		$par_info=$_GET;
        $top_sign = $par_info['top_sign']; 
        //签名验证 
        $sign=base64_encode(md5($par_info['top_appkey'].$par_info['top_parameters'].$par_info['top_session'].$app_secret,true)); 
        $top_parameters = base64_decode($par_info['top_parameters']); 
        $top_parameters= iconv("GBK", "UTF-8",$top_parameters);
        $top_parameters_arr=(spliti('&',$top_parameters));
        if($sign!=$par_info['top_sign']) {
			throw new Exception('Signature verification illegal login unsuccessful!');
			return;
        }
        $retrun_par=array();
        foreach ($top_parameters_arr as $value) {
            $parameters_arr[]=(spliti('=',$value)); 
        }
		foreach($parameters_arr as $key=>$val){
				if($val[0]=='visitor_nick'){
					 $visitor_nick=$val[1];
				}
				else if($val[0]=='visitor_id'){
					 $visitor_id=$val[1];
				}
		}
		$par_arr=array('user_name'=>$visitor_nick,
						'user_id'=>$visitor_id,
						"oauth_secret"=>$par_info['top_session'],
						"oauth_rawdata"=>serialize($parameters_arr)
						);	
		return parent::check($par_arr);
	}
	/*转到第三方登录页*/
    function login() {
        $this->Taoapi_Session= new Taoapi_Session; 
        return $this->Taoapi_Session->loginTaobao();
    }
 	/*获取第三方返回的密钥信息*/
	function getUserOauth(){
		$this->m_Oauth=BizSystem::sessionContext()->getVar("_USEROAUTH_TAOBAO");
		if(!$this->m_Oauth){
			$profile = BizSystem::getUserProfile();   
			$do = BizSystem::getObject($this->m_UserOAuthDO);
			$user_id=$profile['Id'];
			$oauth_class=$this->m_Class;
			$rs = $do->directFetch("[user_id]='$user_id' and oauth_class='$oauth_class'", 1);
			if(isset($rs)){
				$rs=$rs[0];
				foreach ($rs as $key => $value)
					{        		
						$oauth["oauth_".$key] = $value;        	
					}
			}				
			$this->m_Oauth=$oauth;
			BizSystem::sessionContext()->setVar("_USEROAUTH_TAOBAO", $this->m_Oauth);
		}
		return  $this->m_Oauth;
	}
	/*获取用户信息*/
	function getUserInfo(){
		$top_session=$this->GetUserOauth();
		$this->Api->method = 'taobao.user.get';
		$this->Api->session =$top_session['oauth_oauth_secret'];
		$this->Api->fields = 'user_id,nick,sex,buyer_credit,seller_credit,location,created,last_visit,birthday,type,has_more_pic,item_img_num,item_img_size,prop_img_num,prop_img_size,auto_repost,promoted_type,status,alipay_bind,consumer_protection,phone,mobile,email,real_name,has_shop,alipay_account';
		return $this->Api->Send('get','xml')->getArrayData();
	}
}
?>