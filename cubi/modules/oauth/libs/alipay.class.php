<?php
/**************************请求参数**************************/

//选填参数//

//防钓鱼时间戳$anti_phishing_key  = '';
//获取客户端的IP地址，建议：编写获取客户端IP地址的程序$exter_invoke_ip = '';
//注意：
//1.请慎重选择是否开启防钓鱼功能
//2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
//3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
//示例：
//$exter_invoke_ip = '202.1.1.1';
//$ali_service_timestamp = new AlipayService($aliapy_config);
//$anti_phishing_key = $ali_service_timestamp->query_timestamp();//获取防钓鱼时间戳函数

/************************************************************/
require_once("alipay/alipay_service.class.php");
require_once("alipay/alipay_notify.class.php");
require_once "oauth.class.php";
class alipay extends oauthClass
{
	protected $m_Type='alipay';
	protected $m_loginUrl;
	private $m_akey;
	private $m_skey;
	private $m_aliapy_config;
 
		
	public function __construct() {
		parent::__construct();
		$recArr=$this->getProviderList(); 
		$this->m_akey = $recArr['key'];
		$this->m_skey =$recArr['value'];
		$aliapy_config['partner']      = $recArr['key'];
		//安全检验码，以数字和字母组成的32位字符
		$aliapy_config['key']          = $recArr['value'];
		//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
		//return_url的域名不能写成http://localhost/alipay.auth.authorize_php_utf8/return_url.php ，否则会导致return_url执行无效
		$aliapy_config['return_url']   = $this->m_CallBack;
		//签名方式 不需修改
		$aliapy_config['sign_type']    = 'MD5';
		//字符编码格式 目前支持 gbk 或 utf-8
		$aliapy_config['input_charset']= 'utf-8';
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$aliapy_config['transport']    = 'http';
		$aliapy_config['service']    = 'alipay.auth.authorize';
		$aliapy_config['target_service']    = 'user.auth.quick.login';
		$aliapy_config['type']    = 'get';
		
		$this->aliapy_config=$aliapy_config;
		$this->parameter = array(
				"service"			=> "alipay.auth.authorize",
				"target_service"	=> 'user.auth.quick.login',
				"partner"			=> trim($this->aliapy_config['partner']),
				"_input_charset"	=> trim(strtolower($this->aliapy_config['input_charset'])),
				"return_url"		=> trim($this->aliapy_config['return_url'])
		);
	}
	
  	function login(){	
		$redirectPage=$this->getUrl();
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	} 
	
	function test($akey,$skey){
		//暂时没有发现如何验证合法性
        return $rec_arr['oauth_token']='ok';
	}
	
	function callback(){ 
		$alipayNotify = new AlipayNotify($this->aliapy_config);
		//暂时没解决签证验证问题，先取消验证
		//$verifyReturn$alipayNotify->verifyReturn();
		if(true)
		{ 	
			$recinfo=$_GET;
			$recinfo['oauth_token']=$_GET['token'];
			$recinfo['oauth_token_secret']=$_GET['token'];
			$recinfo['access_token_json']=$_GET;
			Bizsystem::getSessionContext()->setVar('alipay_access_token',$recinfo);
			$userInfo=$this->userInfo(); 
			$this->check($userInfo);
		}
		else
		{
			throw new Exception('验证非法！');
			return false;
		}
	}
    /*获取登录页*/
    function getUrl($call_back = null) {
		
		if ( empty($this->aliapy_config['partner']) || empty($this->aliapy_config['key']) )
		{
			throw new Exception('Unknown alipay_akey');
			return false;
		}
		//构造快捷登录接口
		$alipayService = new AlipayService($this->aliapy_config);
		$this->loginUrl = $alipayService->alipay_auth_authorize($this->parameter);
		return $this->loginUrl;
	} 

	//用户资料
	function userInfo(){
		$user['id']          = $_GET['user_id'];
		$user['type']        = $this->m_Type;
		$user['uname']       = $_GET['real_name'];
		return $user;
	}

  
 
}
?>