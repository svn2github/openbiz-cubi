<?php 
include_once(MODULE_PATH."/user/form/RegisterForm.php");
class OauthConnectUserForm extends RegisterForm
{
	protected $username;
    protected $password;

    protected $m_OpenRegisterStatus;
    
    public function CreateUser()
    {
		$OauthUserInfo=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		if(!$OauthUserInfo)
		{
			throw new Exception('Unknown OauthUserInfo');
			return;
		}
		$userObj = BizSystem::getObject('oauth.do.UserTokenDO');
		$OauthUser=$userObj->fetchOne("[oauth_uid]='".$OauthUserInfo['id']."'");
		if(!$OauthUser)
		{
			$userinfo = parent::_doCreateUser();
			//第三方登录用户关联帐号
			if($userinfo['Id'])
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
		}	
		$this->processPostAction();
    }
    
	public function ConnectUser()
	{
	  	// get the username and password	
		$this->username = BizSystem::ClientProxy()->getFormInputs("fld_username");
		$this->password = BizSystem::ClientProxy()->getFormInputs("fld_password");				
		$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
		
		try {
    		if ($this->authUser()) 
    		{
				  // after authenticate user: 1. init profile
    			$profile = BizSystem::instance()->InitUserProfile($this->username);
				$OauthUserInfo=BizSystem::sessionContext()->getVar('_OauthUserInfo');
				if(!$OauthUserInfo || !$profile['Id'])
				{
					$this->m_Errors = array($this->getMessage("TEST_FAILURE"));
					$this->updateForm();
					return false;		
				}
			
				include_once(MODULE_PATH."/oauth/libs/oauth.class.php");
				$OauthObj=new oauthClass();
				if(!$OauthObj->saveUserOAuth($profile['Id'],$OauthUserInfo))
				{
					$this->m_Errors = array("fld_password"=>$this->getMessage("ASSOCIATED_USER_FAILS"));
					$this->updateForm();
					return false;
				}
				else
				{
					//BizSystem::ClientProxy()->showClientAlert($this->getMessage("ASSOCIATED_USER_SUCCESS"));
				}
				$this->switchForm("oauth.form.OauthConnectUserFinishedForm");
/*
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
*/       	              
    		    return true;
    		}
    		else
    		{ 
				$logComment=array($this->username,
    								$_SERVER['REMOTE_ADDR'],
    								$this->password);
				$eventlog->log("LOGIN", "ASSOCIATED_LOGIN_FAILED", $logComment); 	
				$this->m_Errors = array(
				"fld_username"=>$this->getMessage("ASSOCIATED_USER_FAILS"),
				"fld_password"=>" ");
				$this->updateForm();	
				return false;
    		}
    	}
    	catch (Exception $e) {    	
			BizSystem::ClientProxy()->showClientAlert($e->getMessage());
    	
    	}
	}
	
	public function render(){
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		
		if(!$oauth_data)
		{
			header("Location: ".APP_INDEX."/user/login");
			exit;
		}
		
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
        
        if ($this->m_ActiveRecord != null)
        {
        	$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
			$this->m_ActiveRecord['oauth_data'] = $oauth_data;
			$this->m_ActiveRecord['oauth_user'] = $oauth_data['uname'];
			$this->m_ActiveRecord['oauth_location'] = $oauth_data['location'];
            return $this->m_ActiveRecord;
        }

        if (strtoupper($this->m_FormType) == "NEW")       
            return $this->getNewRecord();
            
		//$record =  parent::fetchData();
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$record['oauth_data'] = $oauth_data;
		$record['oauth_user'] = $oauth_data['uname'];
		$record['oauth_location'] = $oauth_data['location'];
		
		$this->m_ActiveRecord = $record;
		return $record;
	}
	
	public function getNewRecord()
	{
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$record= array(
		"username"=>$oauth_data['uname'],
		"email" =>$oauth_data['email']
		);
		$record['oauth_data'] = $oauth_data;
		$record['oauth_user'] = $oauth_data['uname'];
		$record['oauth_location'] = $oauth_data['location'];
		$this->m_ActiveRecord = $record;
		return $record;
	}	
	
    protected function authUser()
    {
    	$svcobj 	= BizSystem::getService(AUTH_SERVICE); 
    	return  $svcobj->authenticateUser($this->username,$this->password); 	
    }
}
?>