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
	private $m_google;
	private $m_oauth2;
	
 
		
	public function __construct() {
		parent::__construct();
		$recArr=$this->getProviderList(); 
		$this->m_akey = $recArr['key'];
		$this->m_skey =$recArr['value'];	
		$this->m_google= new apiClient();
		$this->m_google->setClientId($recArr['key']) ;
		$this->m_google->setClientSecret($recArr['value'] );
		$this->m_google->setRedirectUri($this->m_CallBack);	
	}
	
  	function login(){	
		$redirectPage=$this->getUrl(); 
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	} 

	function test($akey,$skey){
		//暂时没有发现如何验证GOOGLE的Client ID合法性
        return $rec_arr['oauth_token']='ok';
	}
	
	function callback(){  
		$this->oauth2 = new apiOauth2Service($this->m_google);
		$this->m_google->authenticate();
	
		$access_token_json=$this->m_google->getAccessToken();

		$access_token=(array)json_decode($access_token_json);	
		$access_token['oauth_token']=$access_token['access_token'];
		$access_token['oauth_token_secret']=$access_token['id_token'];
		$access_token['access_token_json']=$access_token_json;
		Bizsystem::getSessionContext()->setVar('google_access_token',$access_token);
		
		$userInfo=$this->userInfo();  
		$this->check($userInfo);
	}
	function logout(){ 
		Bizsystem::getSessionContext()->clearVar('google_access_token');
		$this->m_google->revokeToken();
	}
 
    /*获取登录URL*/
    function getUrl($call_back = null) {
 
		if (!$this->m_akey || !$this->m_skey )
		{
			throw new Exception('Unknown akey');
			return false;
		}
		$oauth2 = new apiOauth2Service($this->m_google);
		
		return $this->m_google->createAuthUrl();
	} 

	//用户资料
	function userInfo(){
		$access_token=Bizsystem::getSessionContext()->getVar('google_access_token');
		$this->m_google->setAccessToken($access_token['access_token_json']);
		
		if(!$this->oauth2)
		{
			$this->oauth2 = new apiOauth2Service($this->m_google); 
		}	
		$me = $this->oauth2->userinfo->get();	
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