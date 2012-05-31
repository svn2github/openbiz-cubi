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
 * @version   $Id$
 */

class oauthService extends MetaObject
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
	
	
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    } 
       	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetadata($xmlArr);    
        $this->m_UserOAuthDO 	= isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["USEROAUTHDO"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["USEROAUTHDO"]: "system.do.UserOAuthDO";
		$this->m_Providers	 	= $this->_readProviders();        
    }	

    protected function _readProviders()
    {
    	$xmlFile = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.'oauthService.xml';
    	$xmlArr = BizSystem::getXmlArray($xmlFile);
    	$providersArr=$xmlArr["PLUGINSERVICE"]["PROVIDERS"]['PROVIDER'];
    	foreach($providersArr as $providerInfo){
    		$this->m_Providers[$providerInfo['ATTRIBUTES']['NAME']] = $providerInfo['ATTRIBUTES'];
    	}
    	
    	return $this->m_Providers;
    }
    
	protected function _getProviderData($provider_name = null)
	{
		if($provider_name===null){
			$provider_name = $this->m_Type;
		}
		return $this->m_Providers[$provider_name];
	}    
    
	/**
	 * 
	 * Get OAuth provider data including api_key, api_secret, url etc
	 * @return array;
	 */
	public function getProviderData(){
		if(!$this->m_ProviderData){
			return $this->_getProviderData();
		}else{
			return $this->getProviderData;
		}
	}		
	
	public function getProviderList()
	{
		return $this->m_Providers;
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
		$userObj = BizSystem::getObject('system.do.UserDO');
		$userinfo=$userObj->fetchOne("[username]='".$oauth_data['user_name']."'");
		
		global $g_BizSystem; 
		if(isset($userinfo)){ 
			$UserOAuthobj = BizSystem::getObject('system.do.UserOAuthDO');
			$UserOAuthArr['oauth_secret']=$oauth_data['oauth_secret'];
			$UserOAuthArr['oauth_rawdata']=$oauth_data['oauth_rawdata'];
			$user_id=$userinfo['Id'];
			$UserOAuthobj->updateRecord($UserOAuthArr); 
		}
		else{
			$recArr['username']=$oauth_data['user_name'];      
			$recArr['password'] = hash('sha1',$oauth_data['oauth_secre']);
		
			$user_id=$userObj->insertRecord($recArr);

			//set default user role to member
			$userinfo = $userObj->getActiveRecord();
			
			$RoleDOName = "system.do.RoleDO";
			$UserRoleDOName = "system.do.UserRoleDO";
			
			$roleDo = BizSystem::getObject($RoleDOName,1);
			$userRoleDo = BizSystem::getObject($UserRoleDOName,1);
			
			$roleDo->setSearchRule("[default]=1");
			$defaultRoles = $roleDo->fetch();
			foreach($defaultRoles as $role){
				$role_id = $role['Id'];
				$userRoleArr = array(
					"user_id" => $userinfo['Id'],
					"role_id" => $role_id
				);
				$userRoleDo->insertRecord($userRoleArr);
			}

			//assign a default group to new user
			$GroupDOName = "system.do.GroupDO";
			$UserGroupDOName = "system.do.UserGroupDO";
			
			$groupDo = BizSystem::getObject($GroupDOName,1);
			$userGroupDo = BizSystem::getObject($UserGroupDOName,1);
			
			$groupDo->setSearchRule("[default]=1");
			$defaultGroups = $groupDo->fetch();
			foreach($defaultGroups as $group){
				$group_id = $group['Id'];
				$userGroupArr = array(
					"user_id" => $userinfo['Id'],
					"group_id" => $group_id
				);
				$userGroupDo->insertRecord($userGroupArr);
			}        
			
			$userRoleObj = BizSystem::getObject('system.do.UserRoleDO');
			$uesrRoloArr =array(
							"user_id"=>$userinfo['Id'],
							"role_id"=>"2",  //role 2 is Member
							); 
			$userRoleObj->insertRecord($uesrRoloArr);
			//record event log   
			    
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$logComment=array($userinfo['username'],$_SERVER['REMOTE_ADDR']);
			$eventlog->log("USER_MANAGEMENT", "MSG_USER_REGISTERED", $logComment);   
			//init profile for future use like redirect to my account view
		
			$profile_id = BizSystem::getService(PROFILE_SERVICE)->CreateProfile($userinfo['Id']);
			 //send user email
			$emailObj 	= BizSystem::getService(USER_EMAIL_SERVICE);
			$emailObj->UserWelcomeEmail($userinfo['Id']);
			
			$UserOAuthobj = BizSystem::getObject('system.do.UserOAuthDO');
			$UserOAuthArr['user_id']=$userinfo['Id'];
			$UserOAuthArr['oauth_class']=$this->m_Class;
			$UserOAuthArr['oauth_secret']=$oauth_data['oauth_secret'];
			$UserOAuthArr['oauth_rawdata']=$oauth_data['oauth_rawdata'];
			$UserOAuthobj->insertRecord($UserOAuthArr);  
		} 
			$profile=$g_BizSystem->InituserProfile($userinfo['username']);
			 
		return $profile;
	}
	
	
	public function saveUserOAuth($user_id, $oauth_data)
	{
		
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