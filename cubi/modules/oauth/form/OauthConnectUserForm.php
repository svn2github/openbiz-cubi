<?php 
include_once(MODULE_PATH."/user/form/RegisterForm.php");
class OauthConnectUserForm extends RegisterForm
{
	protected $username;
    protected $password;

    protected $m_OpenRegisterStatus;
    
    public function CreateUser()
    {
    	$userinfo = parent::_doCreateUser();
    	
    	//第三方登录用户关联帐号
		$OauthUserInfo=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		if($OauthUserInfo && $userinfo['Id'])
		{	
			include_once(MODULE_PATH."/oauth/libs/oauth.class.php");
			$OauthObj=new oauthClass();
			if(!$OauthObj->saveUserOAuth($userinfo['Id'],$OauthUserInfo))
			{
				$errorMessage = $this->GetMessage("ASSOCIATED_USER_FAILS");
				$errors['fld_UserOAuth'] = $errorMessage;
				$this->processFormObjError($errors);
			}
		}
    	
		$this->processPostAction();
    }
    
	public function ConnectUser()
	{
	  	// get the username and password	
		$this->username = BizSystem::ClientProxy()->getFormInputs("fld_username");
		$this->password = BizSystem::ClientProxy()->getFormInputs("fld_password");				
		global $g_BizSystem;		
		$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
		try {
    		if ($this->authUser()) 
    		{
				  // after authenticate user: 1. init profile
    			$profile = $g_BizSystem->InitUserProfile($this->username);
				$OauthUserInfo=BizSystem::sessionContext()->getVar('_OauthUserInfo');
				if(!$OauthUserInfo || !$profile['Id'])
				{
					BizSystem::ClientProxy()->showClientAlert($this->getMessage("TEST_FAILURE"));
					return false;		
				}
				
				include_once(MODULE_PATH."/oauth/libs/oauth.class.php");
				$OauthObj=new oauthClass();
				if(!$OauthObj->saveUserOAuth($profile['Id'],$OauthUserInfo))
				{
					BizSystem::ClientProxy()->showClientAlert($this->getMessage("ASSOCIATED_USER_FAILS"));
					return false;
				}
				else
				{
					BizSystem::ClientProxy()->showClientAlert($this->getMessage("ASSOCIATED_USER_SUCCESS"));
				}
		  

    	   	    $redirectPage = APP_INDEX.$profile['roleStartpage'][0];
    	   	   	if(!$profile['roleStartpage'][0])
    	   	   	{
    	   	   		BizSystem::ClientProxy()->showClientAlert($this->getMessage("TEST_FAILURE"));
					return false;
    	   	   	}
    	   	   
				if($profile['roleStartpage'][0]){
       	        	BizSystem::clientProxy()->ReDirectPage($redirectPage);	
       	        }else{
       	        	parent::processPostAction();       	        	
       	        }       	        
    		    return true;
    		}
    		else
    		{ 
				$logComment=array($this->username,
    								$_SERVER['REMOTE_ADDR'],
    								$this->password);
				$eventlog->log("LOGIN", "ASSOCIATED_LOGIN_FAILED", $logComment); 	
				BizSystem::ClientProxy()->showClientAlert($this->getMessage("LOGIN_FAILED"));		
    		}
    	}
    	catch (Exception $e) {    	
			BizSystem::ClientProxy()->showClientAlert($e->getMessage());
    	
    	}
	}
	
	public function render(){
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		/*
		if(!$oauth_data)
		{
			header("Location: ".APP_INDEX."/user/login");
			exit;
		}
		*/
		return parent::render();
	}
	
	public function fetchData()
	{
		//fill in open register status
		$do = BizSystem::getObject("myaccount.do.PreferenceDO");
        $rs = $do->fetchOne("[user_id]='0' AND [name]='open_register'");
        if(!$rs || $rs['value']==0){
        	$this->m_OpenRegisterStatus = 0;	
        }else{
        	$this->m_OpenRegisterStatus = 1;
        }
		$recrod =  parent::fetchData();
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$recrod['oauth_data'] = $oauth_data;
		return $record;
	}
	
	public function getNewRecord()
	{
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$record= array(
		"oauth_data"=>$oauth_data,
		"username"=>$oauth_data['uname'],
		"email" =>$oauth_data['email']
		);
		
		return $record;
	}
    protected function authUser()
    {
    	$svcobj 	= BizSystem::getService(AUTH_SERVICE); 
    	return  $svcobj->authenticateUser($this->username,$this->password); 	
    }
}
?>