<?php
include_once('_OAuth/oauth.php');
require_once ('twitter/twitteroauth.php');
require_once ("oauth.class.php");
class twitter extends oauthClass
{
	protected $m_Type='twitter';
	protected $m_loginUrl;
	private $m_akey;
	private $m_skey;
	private $m_aliapy_config;
	private $m_Twitter;
 
 
		
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
		$Twitter = new TwitterOAuth($akey ,$skey);
        return $Twitter->getRequestToken($this->m_CallBack);
	}
	
	function callback(){ 
		$oauth_token=Bizsystem::getSessionContext()->getVar('twitter_access_token');
		$Twitter = new TwitterOAuth($this->m_akey ,$this->m_skey,$oauth_token['oauth_token'], $oauth_token['oauth_token_secret']);
		$access_token = $Twitter->getAccessToken($_REQUEST['oauth_verifier']);
		if(!$access_token)
		{
			throw new Exception('Unknown facebook AccessToken');
			return false;
		}
		
		Bizsystem::getSessionContext()->setVar($this->m_Type.'_access_token',$access_token);
	
		$userInfo=$this->userInfo($access_token['oauth_token'],$access_token['oauth_token_secret']);
		$this->check($userInfo);
	}
    /*获取登录页*/
    function getUrl($call_back = null) {
		
		if ( empty($this->m_akey) || empty($this->m_skey) )
		{
			throw new Exception('Unknown Twitter_akey');
			return false;
		}
		$Twitter = new TwitterOAuth($this->m_akey ,$this->m_skey);
		$request_token = $Twitter->getRequestToken($this->m_CallBack);
		
		if ($Twitter->http_code==200) 
		{
			/* Build authorize URL and redirect user to Twitter. */
			
			Bizsystem::getSessionContext()->setVar('twitter_access_token',$request_token); 
			$this->loginUrl = $Twitter->getAuthorizeURL($request_token);
		}
		else
		{
			throw new Exception('Could not connect to Twitter. Refresh the page or try again later.');
			return false;
		}
		return $this->loginUrl;
		} 

	//用户资料
	function userInfo($oauth_token=null,$oauth_token_secret=null){
		$Twitter = new TwitterOAuth($this->m_akey ,$this->m_skey,$oauth_token, $oauth_token_secret);
		$me =(array)$Twitter->get('account/verify_credentials');
		$user['id']         = $me['id'];
		$user['type']         = $this->m_Type;
		$user['email']         = '';
		$user['uname']       = $me['name'];
		$user['location']    = $me['location'];
		$user['userface']  = $me['profile_image_url'];	
		return $user;
	}
 
}
?>