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
 * @version   $Id: LoginForm.php 3569 2012-07-10 03:06:09Z hellojixian@gmail.com $
 */

/**
 * LoginForm class - implement the logic of login form
 *
 * @package user.form
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
include_once (MODULE_PATH."/user/form/LoginForm.php");
 
class MobileLoginForm extends LoginForm
{
	protected $MOBILE_STARTPAGE = "/user_mob/user_home";
    /**
     * login action
     *
     * @return void
     */
    public function Login()
    {
	  	$this->MOBILE_STARTPAGE = APP_INDEX.$this->MOBILE_STARTPAGE;
		$recArr = $this->readInputRecord();	  	
	  	try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {        	
            $this->processFormObjError($e->m_Errors);
            return;
        }
	  	        
	  	// get the username and password	
		$this->username = BizSystem::ClientProxy()->getFormInputs("username");
		$this->password = BizSystem::ClientProxy()->getFormInputs("password");		
		$this->smartcard = BizSystem::ClientProxy()->getFormInputs("smartcard");
		
		if($this->username == $this->getElement("username")->m_Hint){
			$this->username = null;
		}
    	if($this->password == $this->getElement("password")->m_Hint){
			$this->password = null;
		}
		
		global $g_BizSystem;		
		$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
		try {
    		if ($this->authUser()) 
    		{
                // after authenticate user: 1. init profile
    			$profile = $g_BizSystem->InitUserProfile($this->username);
    	   	   
    			// after authenticate user: 2. insert login event
    			$logComment=array(	$this->username, $_SERVER['REMOTE_ADDR']);
    			$eventlog->log("LOGIN", "MSG_LOGIN_SUCCESSFUL", $logComment);
    			
    			// after authenticate user: 3. update login time in user record
    	   	    if (!$this->UpdateloginTime())
    	   	        return false;
    	   	            	   	        
    	   	    // after authenticate user: 3. update current theme and language
       			$currentLanguage = BizSystem::ClientProxy()->getFormInputs("current_language");
   				if($currentLanguage!=''){
   				   	if($currentLanguage=='user_default'){
		   				$currentTheme = DEFAULT_LANGUAGE;
		   			}else{
       					BizSystem::sessionContext()->setVar("LANG",$currentLanguage );
		   			}
   				}

				$currentTheme = BizSystem::ClientProxy()->getFormInputs("current_theme");
				if($currentTheme!=''){
					if($currentTheme=='user_default'){
		   				$currentTheme = DEFAULT_THEME_NAME;
		   			}else{
   						BizSystem::sessionContext()->setVar("THEME",$currentTheme );
		   			}
				}
    	   	   		
    	   	    $redirectPage = APP_INDEX.$profile['roleStartpage'][0];
    	   	   	if(!$profile['roleStartpage'][0])
    	   	   	{
    	   	   		$errorMessage['password'] = $this->getMessage("PERM_INCORRECT");
    	   	   		$errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");    			    			
    				$this->processFormObjError($errorMessage);
    				return;
    	   	   	}
    	   	    $cookies = BizSystem::ClientProxy()->getFormInputs("session_timeout");
    	   	    if($cookies)
    	   	    {
    	   	    	$password = $this->password;    	   	    	
    	   	    	$password = md5(md5($password.$this->username).md5($profile['create_time']));
    	   	    	setcookie("SYSTEM_SESSION_USERNAME",$this->username,time()+(int)$cookies,"/");
    	   	    	setcookie("SYSTEM_SESSION_PASSWORD",$password,time()+(int)$cookies,"/");
    	   	    }
    	   	    
    	   	    if($this->m_LastViewedPage!=""){
    	   	    	BizSystem::clientProxy()->ReDirectPage($this->m_LastViewedPage);
    	   	    }
       	        else{
       	        	BizSystem::clientProxy()->ReDirectPage($this->MOBILE_STARTPAGE);    	        	
       	        }       	        
    		    return true;
    		}
    		else
    		{ 
    			switch($this->auth_method)
    			{
    				case "smartcard":
    					$logComment=array($this->smartcard);
    					$eventlog->log("LOGIN", "MSG_SMARTCARD_LOGIN_FAILED", $logComment);    					
    					$errorMessage['smartcard'] = $this->getMessage("SMARTCARD_INCORRECT");
    					break;
    				default:
						$logComment=array($this->username,
    								$_SERVER['REMOTE_ADDR'],
    								$this->password);
    					$eventlog->log("LOGIN", "MSG_LOGIN_FAILED", $logComment);
    					$errorMessage['password'] = $this->getMessage("PASSWORD_INCORRECT");    					
    					break;
    			}
    			
    			$errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");    			    			
    			$this->processFormObjError($errorMessage);    			
    		}
    	}
    	catch (Exception $e) {    	
    		$errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");    			    			
    		$this->processFormObjError($errorMessage);    				
    	    //BizSystem::ClientProxy()->showErrorMessage($e->getMessage());
    	}
    }

}  
?>