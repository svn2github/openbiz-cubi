<?php 
include_once(MODULE_PATH."/system/form/UserForm.php");

class RegisterForm extends UserForm
{
/**
     * Create a user record
     *
     * @return void
     */
    public function CreateUser()
    {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        if ($this->_checkDupUsername())
        {
            $errorMessage = $this->GetMessage("USERNAME_USED");
			$errors['fld_username'] = $errorMessage;
			$this->processFormObjError($errors);
			return;
        }

        if ($this->_checkDupEmail())
        {
            $errorMessage = $this->GetMessage("EMAIL_USED");
			$errors['fld_email'] = $errorMessage;
			$this->processFormObjError($errors);
			return;
        }
                
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        
        $recArr['create_by']="0";
        $recArr['update_by']="0";

        $password = BizSystem::ClientProxy()->GetFormInputs("fld_password");            
		$recArr['password'] = hash(HASH_ALG, $password);
        
        $this->_doInsert($recArr);
                
        //set default user role to member
		$userinfo = $this->getActiveRecord();
        $userRoleObj = BizSystem::getObject('system.do.UserRoleDO');
        $uesrRoloArr =array(
        				"user_id"=>$userinfo['Id'],
        				"role_id"=>"2",  //role 2 is Member
        				); 
         
        $userRoleObj->insertRecord($uesrRoloArr);

        //record event log   
        global $g_BizSystem;     
        $eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
        $logComment=array($userinfo['username'],$_SERVER['REMOTE_ADDR']);
    	$eventlog->log("USER_MANAGEMENT", "MSG_USER_REGISTERED", $logComment);   
    	     
        //send user email
        $emailObj 	= BizSystem::getService(USER_EMAIL_SERVICE);
        $emailObj->UserWelcomeEmail($userinfo['Id']);
        
        //init profile for future use like redirect to my account view
        $profile = $g_BizSystem->InituserProfile($userinfo['username']);
        
        $this->processPostAction();
    }
}

?>