<?php
include_once('_OAuth/oauth.php');
include_once('_OAuth/WeiboOAuth.php');
require_once "oauth.class.php";
include_once( 'qq/txwboauth.php' );
class qq extends oauthClass{
	protected $m_Type='qq';
	protected $m_loginUrl;
	private $m_sina_akey;
	private $m_sina_skey;
		
	public function __construct() {
		$recArr=$this->getProviderList();
		$this->m_qq_akey = $recArr[$this->m_Type]['key'];
		$this->m_qq_skey =$recArr[$this->m_Type]['value'];
	}
	
  	function login(){
		$redirectPage=$this->getUrl(SITE_URL.'oauth_callback_handler.php?type=qq&service=CallBack');
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	} 
	function CallBack(){ 
		//dump($_SESSION['qq']);
		$this->checkUser();
		$userInfo=$this->userInfo();
		$this->check($userInfo);
	}
	function getUrl($call_back){
		if ( empty($this->m_qq_akey) || empty($this->m_qq_skey) )
		{
			throw new Exception('Unknown qq_akey');
			return false;
		}
		$o = new QqWeiboOAuth( $this->m_qq_akey ,$this->m_qq_skey  );
		
		$keys = $o->getRequestToken($call_back);

		$call_back=$call_back.'&oauth_token_secret='.$keys['oauth_token_secret'];
 
		// QQ 返回的oauth_token 的键名有问题，在此临时修正
		$_temp['oauth_token'] = array_shift($keys);
		$keys = array_merge($_temp, $keys);
	
		$this->loginUrl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , $call_back);
		$_SESSION['qq']['keys'] = $keys;
		return $this->loginUrl;
	}

    function qqgetUrl(){
		$o = new QqWeiboOAuth( $this->m_qq_akey ,$this->m_qq_skey  );

		$keys = $o->getRequestToken(U('weibo/operate/qqsava'));

		$this->loginUrl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , "");
		$_SESSION['qq']['keys'] = $keys;
		return $this->loginUrl;
	}


	//用户资料
	function userInfo(){
		$me = $this->doClient()->verify_credentials();
		$user['id']         = $me['data']['name'];
		$user['type']         = $this->m_Type;
		$user['email']         =  $me['data']['email'];
		$user['uname']       = $me['data']['nick'];
		$user['province']    = $me['data']['province_code'];
		$user['city']        = $me['data']['city_code'];
		$user['location']    = $me['data']['location'];
		$user['userface']    = $me['data']['head']."/120";
		$user['sex']         = ($me['data']['sex']=='1')?1:0;

		return $user;
	}

	private function doClient($opt=''){

		$oauth_token = ( $opt['oauth_token'] )? $opt['oauth_token']:$_SESSION['qq']['access_token']['oauth_token'];
        $oauth_token_secret = ( $opt['oauth_token_secret'] )? $opt['oauth_token_secret']:$_SESSION['qq']['access_token']['oauth_token_secret'];

		return new QqWeiboClient( $this->m_qq_akey ,$this->m_qq_skey ,  $oauth_token, $oauth_token_secret  );
	}

	function user($opt)
	{
		return $this->doClient($opt)->user_info();
	}

	//验证用户
	function checkUser(){
          $o = new QqWeiboOAuth($this->m_qq_akey ,$this->m_qq_skey  , $_SESSION['qq']['keys']['oauth_token'] , $_SESSION['qq']['keys']['oauth_token_secret']  );
        $access_token = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
		$_SESSION['qq']['access_token'] = $access_token;
	}

	//发布一条微博
	function update($text,$opt){
		return $this->doClient($opt)->t_add($text);
	}

	//上传一个照片，并发布一条微博
	function upload($text,$opt,$pic){
		if(file_exists($pic)){
			return $this->doClient($opt)->t_add_pic($text,$pic);
		}else{
			return $this->doClient($opt)->t_add($text);
		}
	}

 

}
?>
