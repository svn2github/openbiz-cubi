<?php 
class OauthConnectUserFinishedForm extends EasyForm
{
	public function fetchData()
	{
		$oauth_data=BizSystem::sessionContext()->getVar('_OauthUserInfo');
		$recrod['oauth_data'] = $oauth_data;
		return $record;
	}
}
?>