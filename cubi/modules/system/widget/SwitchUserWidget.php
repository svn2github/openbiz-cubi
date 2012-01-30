<?php 
class SwitchUserWidget extends EasyForm
{
	public $m_ShowWidget = false;
	public function fetchData()
	{
		if(!BizSystem::allowUserAccess('Session.Switch_Session'))
		{
			$this->m_ShowWidget = false;	
			if(!BizSystem::sessionContext()->getVar("_PREV_USER_PROFILE"))
			{
				return ;
			}else{
				$this->m_ShowWidget = true;
			}
		}else{			
			$this->m_ShowWidget = true;
		}		
		$record['username'] = BizSystem::getUserProfile("username");
		return $record;
	}
	
	public function SwitchSession()
	{
		
		if(!BizSystem::allowUserAccess('Session.Switch_Session'))
		{
			if(!BizSystem::sessionContext()->getVar("_PREV_USER_PROFILE"))
			{
				return ;
			}
		}

		$data = $this->readInputRecord();		
		$username = $data['username']; 
		
		if(!$username)
		{
			return ;
		}		
		
		$serviceObj = BizSystem::getService(PROFILE_SERVICE);

        if (method_exists($serviceObj,'SwitchUserProfile')){
            $serviceObj->SwitchUserProfile($username);
        }        
		BizSystem::clientProxy()->runClientScript("<script>window.location.reload();</script>");        
	}
	
    public function outputAttrs()
    {
    	$output = parent::outputAttrs(); 	
    	$output['show_widget'] = $this->m_ShowWidget;
    	return $output;	    
    } 	
}
?>