<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class userService extends  WebsvcService
{
	public function getStatus()
	{
		$result = array();
		$userId = BizSystem::getUserProfile("Id");
		if($userId)
		{
			$result['login_status'] = 1;
		}
		else
		{
			$result['login_status'] = 0;			
		}
		return $result;
	}
}
?>