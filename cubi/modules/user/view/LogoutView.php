<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.user.view
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class LogoutView extends EasyView
{
    public function __construct(&$xmlArr)
    {
        $this->Logout();
    }
    
    public function Logout()
    {
		global $g_BizSystem;
		$eventlog 	= $g_BizSystem->GetService(EVENTLOG_SERVICE);
		$profile = $g_BizSystem->getUserProfile();  
		$logComment=array($profile["username"], $_SERVER['REMOTE_ADDR']);
		
		$eventlog->log("LOGIN", "MSG_LOGOUT_SUCCESSFUL", $logComment);
		
		// destroy all data associated with current session:
		BizSystem::SessionContext()->destroy();
		
		//clean cookies
		setcookie("SYSTEM_SESSION_USERNAME",null,time()-100,"/");
    	setcookie("SYSTEM_SESSION_PASSWORD",null,time()-100,"/");
			
		// Redirect:
		if(isset($_GET['redirect_url']))
		{
			$url = $_GET['redirect_url'];
		}
		else
		{
			$url = "login";	
		}
		
		header("Location: $url");    	
    }
}
?>