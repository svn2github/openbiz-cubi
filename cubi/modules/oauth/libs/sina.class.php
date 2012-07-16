<?php
include_once('_OAuth/oauth.php');
require_once "oauth.class.php";
include_once( 'sina/weibooauth.php' );
class sina extends oauthClass
{
	protected $m_Type='sina';
	protected $m_loginUrl;
	private $m_sina_akey;
	private $m_sina_skey;
		
	public function __construct() {
		$recArr=$this->getProviderList(); 
		$this->m_sina_akey = $recArr['key'];
		$this->m_sina_skey =$recArr['value'];
	}
	
  	function login(){	
		$redirectPage=$this->getUrl();
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	} 
	function CallBack(){ 
		$keys=Bizsystem::getSessionContext()->getVar('sina_keys');
		if(!$keys)
		{
			$keys['oauth_token']=BizSystem::ClientProxy()->getRequestParam("oauth_token");
			$keys['oauth_token_secret']=BizSystem::ClientProxy()->getRequestParam("oauth_token_secret");
		}
		$this->checkUser($keys['oauth_token'],$keys['oauth_token_secret']);
		$userInfo=$this->userInfo();  
		$this->check($userInfo);
	}
    /*获取登录页*/
    function getUrl($call_back = null) {
		if ( empty($this->m_sina_akey) || empty($this->m_sina_skey) )
		{
			throw new Exception('Unknown sina_akey');
			return false;
		}
		$o = new SinaWeiboOAuth( $this->m_sina_akey , $this->m_sina_skey  );
        $keys = $o->getRequestToken();
		if (is_null($call_back)) {
			$call_back =SITE_URL.'oauth_callback_handler.php?type=sina&service=CallBack';
		}
		$call_back=$call_back.'&oauth_token_secret='.$keys['oauth_token_secret'];
		$this->loginUrl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , $call_back);
		//$_SESSION['sina']['keys'] = $keys;
		Bizsystem::getSessionContext()->setVar('sina_keys',$keys);
		//dump(Bizsystem::getSessionContext()->getVar('sina_keys'));
		return $this->loginUrl;
	} 

	//用户资料
	function userInfo(){
		$me = $this->doClient()->verify_credentials();
		$user['id']          = $me['id'];
		$user['type']        = $this->m_Type;
		$user['uname']       = $me['name'];
		$user['province']    = $me['province'];
		$user['city']        = $me['city'];
		$user['location']    = $me['location'];
		$user['userface']    = str_replace(  $user['id'].'/50/' , $user['id'].'/180/' ,$me['profile_image_url'] );
		$user['sex']         = ($me['gender']=='m')?1:0; 
		return $user;
	}

	//验证用户
    function checkUser($oauth_token,$oauth_token_secret){
        $o = new SinaWeiboOAuth( $this->m_sina_akey , $this->m_sina_skey ,$oauth_token ,$oauth_token_secret);
        $access_token = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
		//$_SESSION['sina']['access_token']= $access_token;
		Bizsystem::getSessionContext()->setVar('sina_access_token',$access_token);
		//$this->m_oauth_token = $access_token['oauth_token'];
		//$this->m_oauth_token_secret = $access_token['oauth_token_secret'];
	}
    private function doClient($opt=''){
		$tokens=Bizsystem::getSessionContext()->getVar('sina_access_token');
		$oauth_token = ( $opt['oauth_token'] )? $opt['oauth_token']:$tokens['oauth_token'];
        $oauth_token_secret = ( $opt['oauth_token_secret'] )? $opt['oauth_token_secret']:$tokens['oauth_token_secret'];	
		return new WeiboClient( $this->m_sina_akey , $this->m_sina_skey ,  $oauth_token, $oauth_token_secret  );
	}
	//发布一条微博 - 可以发图片微博
	function update($text,$opt){
		return $this->doClient($opt)->update($text);
	}

	//上传一个照片，并发布一条微博
	function upload($text,$opt,$pic){
		if(file_exists($pic)){
			return $this->doClient($opt)->upload($text,$pic);
		}else{
			return $this->doClient($opt)->update($text);
		}
	}
 
}
?>