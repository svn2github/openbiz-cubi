<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class mobileService extends  WebsvcService
{
	public function getServerInfo()
	{
		$result = array(
			'system_name' => DEFAULT_SYSTEM_NAME,
			'system_icon' => SITE_URL.'/images/cubi_logo_large.png'
		);
		return $result;
	}	
	
	public function login()
	{
		$result = array(
			"user_id" => 10
		);
		return $result;
	}
}
?>