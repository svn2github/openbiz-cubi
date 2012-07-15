<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.user.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

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
        
		//第三方登录用户关联帐号
		$OauthUserInfo=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		if($OauthUserInfo && $userinfo['Id'])
		{	
			 $UserTokenObj = BizSystem::getObject('oauth.do.UserTokenDO');
			 $UserTokenArr=array(
								"user_id"=>$userinfo['Id'],
								"type_uid"=>$OauthUserInfo['id'],
								"oauth_class"=>$OauthUserInfo['type'],
								"oauth_token"=>$OauthUserInfo['oauth_token'],
								"oauth_token_secret"=>$OauthUserInfo['oauth_token_secret'],
								"create_by"=>$userinfo['Id'],
								"create_time"=> date("Y-m-d H:i:s")
							);
			 $UserTokenObj->insertRecord($UserTokenArr);
		}
        $this->processPostAction();
    }
}

?>