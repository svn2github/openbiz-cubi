<?php 
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
		header("Location: login");    	
    }
}
?>