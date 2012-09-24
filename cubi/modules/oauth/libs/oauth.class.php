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
 * @version   $Id: oauthService.php 3371 2012-05-31 06:17:21Z rockyswen@gmail.com $
 */

class oauthClass extends EasyForm
{
	/**
	 * 
	 * OAuth type 
	 * e.g.: Taobao or Facebook etc..
	 * @var string
	 */
	protected $m_Type;
		
	/**
	 * 
	 * Temperary cache provider data
	 * @var array
	 */
	protected $m_ProviderData;
		
	/**
	 * 
	 * Data Object for storage users oauth token info
	 * @var string
	 */
	protected $m_UserOAuthDO;
 
	protected $m_Providers;
	protected $m_CallBack;
 
	protected $m_oauthProviderDo='oauth.do.OauthProviderDO';
	
	
  public function __construct()  
    {
         $this->m_CallBack=SITE_URL.'ws.php/oauth/callback/callback/type_'.$this->m_Type.'/';
    } 

    
	/**
	 * 
	 * Get OAuth provider data including api_key, api_secret, url etc
	 * @return array;
	 */	
	
	public function getProviderList()
	{
	  	 $recArr=BizSystem::sessionContext()->getVar("_OAUTH_{$this->m_Type}");
	  	 $recArr=false;
		 if(!$recArr)
			 {
			 $do=BizSystem::getObject($this->m_oauthProviderDo);
			 $recArr=$do->fetchOne("[status]=1 and [type]='{$this->m_Type}'",1);
			 if($recArr)
			 {
				$recArr=$recArr->toArray();
			 }
			 BizSystem::sessionContext()->setVar("_OAUTH_{$this->m_Type}",$recArr);
		 }
		 $recArr['key']=trim($recArr['key']);
		 $recArr['value']=trim($recArr['value']);
		 return $recArr;
	}
	

	/**
	 * 
	 * abstract functions need to be implement in sub class
	 * Validate if the oauth info still available 
	 * @param intger $user_id
	 * @param intger $oauth_id
	 * @return bool
	 */	
	public function validateUserOAuth($user_id,$oauth_id){}
	
	/**
	 * 
	 * avstract function to check given oauth_data is valid or not
	 * @param array oauth_data
	 * @return bool
	 */
	public function check($oauth_data){

		if(!$oauth_data['id'])
		{
			throw new Exception('Unknown oauth_token');
			return;
		}
	
		$UserTokenObj = BizSystem::getObject('oauth.do.UserTokenDO');
		$UserToken=$UserTokenObj->fetchOne("[oauth_uid]='".$oauth_data['id']."'");
		$access_token=Bizsystem::getSessionContext()->getVar($this->m_Type.'_access_token');
		$oauth_data['oauth_token']=$access_token['oauth_token'] ; 
		$oauth_data['oauth_token_secret']=$access_token['oauth_token_secret']; 
		$oauth_data['access_token_json']=$access_token['access_token_json']; 
	
		if($UserToken)
		{
			 $UserOAuthArr['oauth_token']=$oauth_data['oauth_token'];
			 $UserOAuthArr['oauth_token_secret']=$oauth_data['oauth_token_secret'];
			 $UserOAuthArr['oauth_rawdata']=serialize($oauth_data['access_token_json']);
			 $UserOAuthArr['oauth_user_info']=serialize($oauth_data);
		    // $dataRec = new DataRecord($UserOAuthArr, $UserTokenObj);
			// $dataRec->id =$UserToken['Id'];
			//$dataRec->save( ); 
		
			$UserTokenObj->updateRecords($UserOAuthArr,"[Id]={$UserToken['Id']}"); 
			$userObj = BizSystem::getObject('system.do.UserDO');
			$userinfo=$userObj->fetchOne("id='".$UserToken['user_id']."'");
		
			$profile=BizSystem::instance()->InituserProfile($userinfo['username']);
			//获取当前用户角色的默认页
			$index=$profile['roles'][0];  
			$roleStartpage=$rec_info['roleStartpage'][$index];
			$redirectPage = APP_INDEX.$roleStartpage;
			$redirectURL = BizSystem::sessionContext()->getVar("oauth_redirect_url");
			if($redirectURL){
				$redirectPage = $redirectURL;
			}
			BizSystem::clientProxy()->ReDirectPage($redirectPage);
		}
		else
		{	 
			//未找到用户，跳转到注册页
			BizSystem::sessionContext()->setVar('_OauthUserInfo',$oauth_data);
			$assocURL = BizSystem::sessionContext()->getVar("oauth_assoc_url");
			if($assocURL){
				header("Location: ".$assocURL);
			}
			else
			{
				header("Location: ".APP_INDEX."/oauth/connect_user");
			}
		}
		 	return $profile;
	}
	
	
	public function saveUserOAuth($user_id, $OauthUserInfo)
	{
		if(!$user_id || !$OauthUserInfo)
		{
			throw new Exception('Unknown UserInfo');
			return;
		}
 
		 $UserTokenObj = BizSystem::getObject('oauth.do.UserTokenDO');
		 $UserTokenArr=array(
							"user_id"=>$user_id,
							"oauth_uid"=>$OauthUserInfo['id'],
							"oauth_class"=>$OauthUserInfo['type'],
							"oauth_token"=>$OauthUserInfo['oauth_token'],
							"oauth_token_secret"=>$OauthUserInfo['oauth_token_secret'],
							"oauth_rawdata"=>serialize($OauthUserInfo['access_token_json']),
							"oauth_user_info"=>serialize($OauthUserInfo),
							"create_by"=>$user_id,
							"create_time"=> date("Y-m-d H:i:s")
						);
		 $return= false;	
		 if($UserTokenObj->insertRecord($UserTokenArr))
		 {
			$return= true;
		 }
		 return $return;
	}

	public function clearUserOAuth($user_id, $oauth_id)
	{
		
	}

	public function getUserOAuthList($user_id)
	{
		
	}
	/*
	 This method will used for redirect to 3rd party platform login page
	*/
	public function login(){
	
	}
	
	public function getUserOauth(){
	
	}
	public function getUserInfo(){
	
	}

}
?>