<?php

require_once('_OAuth/oauth.php');
require_once "oauth.class.php";
class alitao extends oauthClass
{
	protected $m_Type='alitao'; 
	protected $m_tokenUrl='https://oauth.taobao.com/token';
	protected $m_authorizeUrl='https://oauth.taobao.com/authorize';//登录验证地址
	protected $loginUrl;
	private $m_akey;
	private $m_skey;
	
	public function __construct() {
		parent::__construct();
		$recArr=$this->getProviderList(); 
		$this->m_akey = $recArr['key'];
		$this->m_skey =$recArr['value']; 
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
		
		  //请求参数
		 $postfields= array('grant_type'     => 'authorization_code',
							 'client_id'     => $this->m_akey,
							 'client_secret' => $this->m_skey,
							 'code'          => $_REQUEST['code'],
							 'redirect_uri'  => $this->m_CallBack
						);
		 $token = json_decode(OAuthUtil::Curl_Post($this->m_tokenUrl,$postfields),true); 
	
		if($token['access_token'])
		{ 	
			$recinfo['oauth_token']=$token['access_token'];
			$recinfo['oauth_token_secret']='';
			$recinfo['access_token_json']=$token;
			Bizsystem::getSessionContext()->setVar('alitao_access_token',$recinfo);
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
		/*oauth.taobao.com/authorize?response_type=code&client_id
		 * =12382619&redirect_uri=127.0.0.1/loginDemo/oauthLogin.php&state=1
		 */
		$this->loginUrl=$this->m_authorizeUrl.'?response_type=code&client_id='.$this->m_akey.'&redirect_uri='.$this->m_CallBack;
		return $this->loginUrl;
	}  

	//用户资料
	function userInfo(){
		$recinfo=Bizsystem::getSessionContext()->getVar('alitao_access_token');
	
		$user['id']          = $recinfo['access_token_json']['taobao_user_id'];
		$user['type']        = $this->m_Type;
		$user['uname']       = urldecode($recinfo['access_token_json']['taobao_user_nick']);
		return $user;
	}

 
 
}
?>