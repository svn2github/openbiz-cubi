<?php
require_once ('facebook/facebook.php');
require_once ("oauth.class.php");
class facebook extends oauthClass
{
	protected $m_Type='facebook';
	protected $m_loginUrl;
	private $m_akey;
	private $m_skey;
	private $m_aliapy_config;
	private $m_facebook;
 
 
		
	public function __construct() {
		parent::__construct();
		$recArr=$this->getProviderList(); 
		$this->m_akey = $recArr['key'];
		$this->m_skey =$recArr['value']; 
		$this->m_facebook = new FacebookApi(array(
		  'appId'  => $this->m_akey,
		  'secret' => $this->m_skey,
		  'CallBack' => $this->m_CallBack,
		));
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
		$access_token['oauth_token']=$this->m_facebook->getAccessToken();
		if(!$access_token)
		{
			throw new Exception('Unknown facebook AccessToken');
			return false;
		}
		$getSigned=$this->m_facebook->getSignedRequest();
		$access_token['access_token_json']=$_GET;
		$access_token['oauth_token_secret']=$_GET['code'];
		Bizsystem::getSessionContext()->setVar($this->m_Type.'_access_token',$access_token);
		$userInfo=$this->userInfo();
		$this->check($userInfo);
	}
    /*获取登录页*/
    function getUrl($call_back = null) {
		
		if ( empty($this->m_akey) || empty($this->m_skey) )
		{
			throw new Exception('Unknown Facebook_akey');
			return false;
		}
		$this->loginUrl = $this->m_facebook->getLoginUrl();
	
		return $this->loginUrl;
	} 

	//用户资料
	function userInfo(){
		$me = $this->m_facebook->api('/me');
		$user['id']         = $me['id'];
		$user['type']         = $this->m_Type;
		$user['email']         = $me['data']['email'];
		$user['uname']       = $me['name'];
		$user['location']    = $me['locale'];
		$user['sex']         = ($me['gender']=='male')?1:0;	
		$user['first_name']  = $me['first_name'];	
		$user['last_name']  = $me['last_name'];	
		$user['username']  = $me['username'];	
		$user['verified']  = $me['verified'];	
		$user['updated_time']  = $me['updated_time'];	
		$user['userface']  = 'https://graph.facebook.com/'.$me['id'].'/picture';	
		return $user;
	}
 
}
?>