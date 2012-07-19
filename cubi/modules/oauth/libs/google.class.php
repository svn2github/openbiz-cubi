<?php
require_once "oauth.class.php";
require_once 'google/apiClient.php';
require_once 'google/contrib/apiOauth2Service.php';
class google extends oauthClass
{
	protected $m_Type='google';
	protected $m_loginUrl;
	private $m_akey;
	private $m_skey;
	
 
		
	public function __construct() {
		parent::__construct();
		$recArr=$this->getProviderList(); 
		$this->m_akey = $recArr['key'];
		$this->m_skey =$recArr['value'];
	}
	
  	function login(){	
		$redirectPage=$this->getUrl(); dump($redirectPage);
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	} 
	
	function test($akey,$skey){
		//暂时没有发现如何验证GOOGLE的Client ID合法性
        return $rec_arr['oauth_token']='ok';
	}
	
	function CallBack(){  
		$client = new apiClient();
		$client->setClientId=$this->m_akey;
		$client->setClientSecret=$this->m_skey;
		
		$oauth2 = new apiOauth2Service($client);
		$client->authenticate();
		$access_token_json=$client->getAccessToken();
	 
		$access_token=(array)json_decode($access_token_json);	
		$access_token['oauth_token']=$access_token['access_token'];
		$access_token['oauth_token_secret']=$access_token['id_token'];
		$access_token['access_token_json']=$access_token_json;
		Bizsystem::getSessionContext()->setVar('google_access_token',$access_token);
		
		$userInfo=$this->userInfo();  
		$this->check($userInfo);
	}
	function logout(){ 
		$client = new apiClient();
		$client->setClientId=$this->m_akey;
		$client->setClientSecret=$this->m_skey;
		Bizsystem::getSessionContext()->clearVar('google_access_token');
		$client->revokeToken();
	}
 
    /*获取登录页*/
    function getUrl($call_back = null) {
		if ( empty($this->m_akey) || empty($this->m_skey) )
		{
			throw new Exception('Unknown sina_akey');
			return false;
		}
		
		
		$client = new apiClient();
	
		$client->setClientId=$this->m_akey;
		$client->setClientSecret=$this->m_skey;
		$client->setRedirectUri=$this->m_CallBack;
	
		$oauth2 = new apiOauth2Service($client);
		
		return $client->createAuthUrl();
	} 

	//用户资料
	function userInfo(){
		$access_token=Bizsystem::getSessionContext()->getVar('google_access_token');
		$client = new apiClient();
		$client->setClientId=$this->m_akey;
		$client->setClientSecret=$this->m_skey;
		$client->setAccessToken($access_token['access_token_json']);
		$oauth2 = new apiOauth2Service($client);
		$me = $oauth2->userinfo->get();
		$user['id']          = $me['id'];
		$user['type']        = $this->m_Type;
		$user['uname']       = $me['name'];
		$user['province']    = '';
		$user['city']        = '';
		$user['location']    = $me['locale'];
		$user['email']         = $me['email'];
		$user['userface']    = $me['picture'];
		$user['sex']         = ($me['gender']=='male')?1:0; 
		return $user;
	}

	//验证用户
    function checkUser($oauth_token,$oauth_token_secret){
        
	}
 
 
}
?>