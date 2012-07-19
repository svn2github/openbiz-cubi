<?php 
class UserOauthListWidgetForm extends EasyForm
{
	public function fetchDataset()
	{
		$resultSet = parent::fetchDataSet();
		return $resultSet;
	}
	
	public function deleteAccount($id=null)
	{
		$result = parent::deleteRecord($id);
		//also notify remote service provider		
	}
	
	public function SyncAccounts()
	{
		//update all user_info fields
		//if cannot read user's info , then delete the association
	}
}
?>