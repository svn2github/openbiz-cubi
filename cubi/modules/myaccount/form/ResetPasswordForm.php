<?php 
/**
 * Openbiz Cubi 
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   user.form
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

/**
 * ForgetPassForm class - implement the logic of forget password form
 *
 * @package user.form
 * @author Jixian Wang
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
include_once(MODULE_PATH."/system/form/UserForm.php");

class ResetPasswordForm extends UserForm
{
    public function allowAccess(){
    	parent::allowAccess();

    	if(BizSystem::getUserProfile("Id"))
    	{
  	 		return 1;
    	}
    	else
    	{
    		return 0;
    	}
    }
    
    public function resetPassword()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
        	$this->processFormObjError($e->m_Errors);
            return;
        }
        
        //check old password
        $old_password = BizSystem::ClientProxy()->GetFormInputs("fld_password_old");
        if(!$this->checkPassword($old_password)){
        	$error = array("fld_password_old"=>$this->GetMessage("OLD_PASSOWRD_INVAILD"));
        	$this->processFormObjError($error);
        	return;
        }

        $password = BizSystem::ClientProxy()->GetFormInputs("fld_password");            
        if($password){
        	$recArr['password'] = hash(HASH_ALG, $password);
		}        
        
        if (count($recArr) == 0)
            return;

        $this->_doUpdate($recArr, $currentRec);
        
        
        // if 'notify email' option is checked, send confirmation email to user email address
        // ...

		// init profile
	    global $g_BizSystem;
	    $profile = $g_BizSystem->InitUserProfile($currentRec['username']);
    				       	
       	//run eventlog
        $eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
        $logComment=array($currentRec['username']);
    	$eventlog->log("USER_MANAGEMENT", "MSG_RESET_PASSWORD_BY_TOKEN", $logComment);       	
	    
        $this->m_Notices[] = $this->GetMessage("USER_DATA_UPDATED");
        $this->updateForm();
 
    }
    
    public function checkPassword($password){
    	if(!$password){
    		return false;
    	}
    	$currentRec = $this->fetchData();
    	$username= $currentRec['username'];
    	$svcobj 	= BizSystem::getService(AUTH_SERVICE);
    	$result = $svcobj->authenticateUser($username,$password);
    	return $result;
    	
    }
        
    private function validateToken($token){
    	if(empty($token))
    	{
    		return false;
    	}
    	
    	$tokenObj = BizSystem::getObject('system.do.UserPassTokenDO');
        $tokenArr = $tokenObj->directFetch("[token]='$token'", 1);
        if(count($tokenArr)==1)
        {
        	$tokenArr = $tokenArr[0];
        	$expiration = $tokenArr['expiration'];
        	if(strtotime($expiration) > time() )
        	{
        		return $tokenArr['user_id'];
        	}else{
        		return false;
        	}
        }
        else
        {
        	return false;
        }
        return true;
    }
    
    protected function _checkDupUsername(){
    	//its not gonna change username so doesnt matter
    	return false;
    }
    protected function _checkDupEmail(){
    	//its not gonna change email address so doesnt matter
    	return false;
    }    
}  
?>   