<?php

require_once('_OAuth/oauth.php');
require_once "oauth.class.php";
class baiduapp extends oauthClass
{
	protected $m_Type='baiduapp'; 
	protected $m_tokenUrl='https://openapi.baidu.com/oauth/2.0/token';
	protected $m_userUrl='https://openapi.baidu.com/rest/2.0/passport/users/getInfo';
	protected $m_authorizeUrl='https://openapi.baidu.com/oauth/2.0/authorize';//登录验证地址
	protected $loginUrl;
	protected $m_UserPass='www.openbiz.cn';
	private $m_akey;
	private $m_skey;
	private $m_suffix='@baiduaccount';
	
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
		if(!$_REQUEST['code'])
		{
			exit('code为空');
		} 
		 $token = json_decode(OAuthUtil::Curl_Post($this->m_tokenUrl,$postfields),true); 
			
		if($token['access_token'])
		{ 	
			$recinfo['oauth_token']=$token['access_token'];
			$recinfo['oauth_token_secret']=$token['session_secret'];
			$recinfo['access_token_json']=$token;
			Bizsystem::getSessionContext()->setVar($this->m_Type.'_access_token',$recinfo);
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
    public function getUrl($call_back = null) {
		/*oauth.taobao.com/authorize?response_type=code&client_id
		 * =12382619&redirect_uri=127.0.0.1/loginDemo/oauthLogin.php&state=1
		 * http://taotools.bbaos.com/ws.php/oauth/callback/callback/type_alitao/app_TitleOptimization/
		 */
		$this->loginUrl=$this->m_authorizeUrl.'?response_type=code&client_id='.$this->m_akey.'&redirect_uri='.$this->m_CallBack.'&display=page';

		return $this->loginUrl;
	}  

	//用户资料
	public function userInfo(){
		$recinfo=Bizsystem::getSessionContext()->getVar($this->m_Type.'_access_token');
		$postfields=array('access_token'=>$recinfo['oauth_token'],'format'=>'json');

		$user=json_decode(OAuthUtil::Curl_Post($this->m_userUrl,$postfields),true);

		if(!$user)
		{
			return false;
		}
		$user['id']          = $user['userid'];
		$user['type']        = $this->m_Type;
		$user['uname']       = $user['username'].$this->m_suffix;
		return $user;
	}
	public function autoCreateUser()
	{
		return $this->CreateUser();
	}
}

?>