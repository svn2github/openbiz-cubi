<?php 
class OauthConnectUserFinishedForm extends EasyForm
{
	public $m_BackURL;
	
	public function fetchData()
	{
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$record['oauth_data'] = $oauth_data;
		$record['oauth_user'] = $oauth_data['uname'];
		$record['oauth_location'] = $oauth_data['location'];	

		$record['local_user'] = BizSystem::getUserProfile("username");
		$record['local_email'] = BizSystem::getUserProfile("email");
		
		$redirectURL = BizSystem::sessionContext()->getVar("oauth_redirect_url");
		if($redirectURL)
		{
			$this->m_BackURL = $redirectURL;
		}
		else
		{
			//$this->m_BackURL = APP_INDEX.'/myaccount/my_social_account';
			$this->m_BackURL = APP_INDEX;
		}
		return $record;
	}
	
	
}
?>