<?php 
class OauthConnectUserForm extends EasyForm
{
	public function CreateUser()
	{
		
	}
	
	public function ConnectUser()
	{
		
	}
	
	public function getNewRecord()
	{
		$record= array(
		"username"=>'Test User',
		"email" =>'test Email'
		);
		return $record;
	}
}
?>