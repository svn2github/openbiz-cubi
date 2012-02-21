<?php
class profileService
{
    protected $m_Name = "ProfileService";
    protected $m_Profile;    
    protected $m_profileObj = "contact.do.ContactSystemDO";
    protected $m_contactObj = "contact.do.ContactSystemDO";     
    protected $m_userDataObj = "system.do.UserDO";
    protected $m_user_roleDataObj = "system.do.UserRoleDO";
    protected $m_user_groupDataObj = "system.do.UserGroupDO";

    public function __construct(&$xmlArr)
    {
        //$this->readMetadata($xmlArr);
    }

    protected function readMetadata(&$xmlArr)
    {
        //$this->m_profileObj = $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["BIZDATAOBJ"];
    }

    public function InitProfile($userName)
    {
    	//clear ACL Cache
		BizSystem::getService(ACL_SERVICE)->clearACLCache();     	
    	
        $this->m_Profile = $this->InitDBProfile($userName);        
        BizSystem::sessionContext()->setVar("_USER_PROFILE", $this->m_Profile);
        
        //load preference
        $pref = BizSystem::getService(PREFERENCE_SERVICE);
        $pref->InitPreference($this->m_Profile["Id"]);       
        
        return $this->m_Profile;
    }

    public function getProfile($attr=null)
    {
        if (!$this->m_Profile)
        {
            $this->m_Profile = BizSystem::sessionContext()->getVar("_USER_PROFILE");
        }
        if (!$this->m_Profile)
        {
            $this->getProfileByCookie();
            if (!$this->m_Profile)
        		return null;
        }

        if ($attr){
        	if(isset($this->m_Profile[$attr])){
        		return $this->m_Profile[$attr];
        	}else{
        		return null;
        	}
        }
            
        return $this->m_Profile;
    }

    public function SetProfile($profile)
    {
        $this->m_Profile = $profile;
    }

    public function CreateProfile($user_id=null){
    	if(!$user_id){
    		$user_id = $this->getProfile("Id");
    	}
    	
    	$profileDo = BizSystem::getObject($this->m_profileObj,1);
        $userinfo = BizSystem::getObject($this->m_userDataObj,1)->fetchById($user_id);
        $profileArr = array(
        		"first_name" => $userinfo['username'],
        		"last_name" => $userinfo['username'],
        		"display_name" => $userinfo['username'],
        		"fast_index" => substr(strtolower($userinfo['username']),0,1),
        		"email" => $userinfo['email'],
        		"company" => "N/A",
        		"user_id" => $user_id,
        		"group_perm" => '1',
        		"type_id" => '1',
        		"other_perm" => '1',
        );
        $profile_id = $profileDo->insertRecord($profileArr);
    	return $profile_id;
    }    
    
    public function checkExist($profile_id){
    	$profileDo = BizSystem::getObject($this->m_profileObj,1);
    	$profile = $profileDo->fetchById($profile_id);
    	
    	if($profile){
    		return true;
    	}else{
    		return false;
    	}
    	
    }
    
    protected function getProfileByCookie()
    {
    	//print_r($_COOKIE);
        if (isset($_COOKIE["SYSTEM_SESSION_USERNAME"]) && isset($_COOKIE["SYSTEM_SESSION_PASSWORD"]))
		{
			$username = $_COOKIE["SYSTEM_SESSION_USERNAME"];
			$password = $_COOKIE["SYSTEM_SESSION_PASSWORD"];
			
			$svcobj = BizSystem::getService(AUTH_SERVICE);
			if ($svcobj->authenticateUserByCookies($username,$password)) 
			{
				$this->InitProfile($username);
			}
			else {
				setcookie("SYSTEM_SESSION_USERNAME",null,time()-100,"/");
    	 		setcookie("SYSTEM_SESSION_PASSWORD",null,time()-100,"/");
			}
		}
		return null;
    }

    protected function InitDBProfile($username)
    {
        // fetch user record
        $do = BizSystem::getObject($this->m_userDataObj);
        if (!$do)
            return false;

        $rs = $do->directFetch("[username]='$username'", 1);
        if (!$rs)
            return null;

        // set the profile array
        $userId = $rs[0]['Id'];
        $profile = $rs[0];
        $profile['password'] = null;
        $profile['enctype'] = null;
        
    	$do = BizSystem::getObject($this->m_profileObj,1);
        if (!$do)
            return false;

        $rs = $do->directFetch("[user_id]='$userId'", 1);
        if ($rs)
        {
        	$rs = $rs[0];        	
        	if($rs!=null){
	        	foreach ($rs as $key => $value)
	        	{        		
	        		$profile["profile_".$key] = $value;        	
	        	}	
        	}
        }
        // fetch roles and set profile roles
        $do = BizSystem::getObject($this->m_user_roleDataObj);
        $rs = $do->directFetch("[user_id]='$userId'");
        if ($rs)
        {
            foreach ($rs as $rec)
            {
                $profile['roles'][] = $rec['role_id'];
                $profile['roleNames'][] = $rec['role_name'];
                $profile['roleStartpage'][] = $rec['role_startpage'];                
            }
        }
        // fetch groups and set profile groups
        $gdo = BizSystem::getObject($this->m_user_groupDataObj);
        $rs = $gdo->directFetch("[user_id]='$userId'");
        if ($rs)
        {
            $profile['default_group'] = null;
            foreach ($rs as $rec)
            {
                $profile['groups'][] = $rec['group_id'];
                $profile['groupNames'][] = $rec['group_name'];
                if ($rec['default']==1 && $profile['default_group']==null){
                    $profile['default_group'] = $rec['group_id'];
                    $profile['default_group_name'] = $rec['group_name'];
                }
            }            
        }
    	if($profile['default_group']==null)
        {
        	$profile['default_group'] = $rs[0]['group_id'];
        	$profile['default_group_name'] = $rs[0]['group_name'];
        }
        return $profile;
    }

    public function SwitchUserProfile($userId)
    {
    	//get previously profile
    	if(!BizSystem::sessionContext()->getVar("_PREV_USER_PROFILE"))
    	{
    		$prevProfile = BizSystem::sessionContext()->getVar("_USER_PROFILE");
    		BizSystem::sessionContext()->clearVar("_USER_PROFILE");
    		BizSystem::sessionContext()->setVar("_PREV_USER_PROFILE", $prevProfile);
    	}
    	BizSystem::initUserProfile($userId);    	
    }
    
    public function GetProfileName($account_id,$type='full'){
    	$do = BizSystem::getObject($this->m_userDataObj);
        if (!$do)
            return "";
		if($account_id==0)
		{
			$msg = "-- Not Available --";			
			return $msg;
		}
        
        $rs = $do->fetchById($account_id);
        if (!$rs){
			$msg = "-- Deleted User ( UID:$account_id ) --";			
			return $msg;			
        }
        $contact_do = BizSystem::getObject($this->m_contactObj);
        $contact_rs = $contact_do->directFetch("[user_id]='$account_id'", 1);
        if (count($contact_rs)==0){
        	//$name = $rs['username']." &lt;".$rs['email']."&gt;";
            $name = $rs['username'];
            $email = $rs['email'];
        	if($email){
        		$name.=" <$email>";
        	}            
        }else{
        	$contact_rs = $contact_rs[0];
        	if($contact_rs['email'])
        	{
        		$email = $contact_rs['email'];
        	}else{
        		$email = $rs['email'];
        	}
        	$name = $contact_rs['display_name'];
        	if($email && $type=='full'){
        		$name.=" <$email>";
        	}
        }
        return $name;
    }
    
    
	public function GetProfileEmail($account_id){
    	$do = BizSystem::getObject($this->m_userDataObj);
        if (!$do)
            return "";

        
        $rs = $do->fetchById($account_id);
        if (!$rs){
			$msg = "-- Deleted User ( UID:$account_id ) --";
			return $msg;
			
        }
        
        return $rs['email'];
    }
}

?>