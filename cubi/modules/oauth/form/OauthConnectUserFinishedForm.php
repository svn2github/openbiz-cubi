<?php 
class OauthConnectUserFinishedForm extends EasyForm
{
	public function fetchData()
	{
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$record['oauth_data'] = $oauth_data;
		$record['oauth_user'] = $oauth_data['uname'];
		$record['oauth_location'] = $oauth_data['location'];	

		$record['local_user'] = BizSystem::getUserProfile("username");
		$record['local_email'] = BizSystem::getUserProfile("email");
		return $record;
	}
}
?>