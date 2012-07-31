<?php 
class UserOauthListWidgetForm extends EasyForm
{
	public function fetchDataset()
	{
		$resultSet = parent::fetchDataSet();
		foreach($resultSet as $key=>$value)
		{
			$userInfo = $value['oauth_user_info']; 
			$userInfoArr = unserialize($userInfo);
			if(is_array($userInfoArr)){
				foreach($userInfoArr as $infoKey=>$infoValue)
				{
					$value[$infoKey]=$infoValue;
				}
			}
			$resultSet[$key] = $value;
		}
		return $resultSet;
	}
	
	public function deleteAccount($id=null)
	{
		$rec=$this->getDataObj()->fetchById($id);
		$profile_id = BizSystem::getUserProfile("Id");
		if($rec['user_id'] == $profile_id){
			$result = parent::deleteRecord($id);
		}
		//also notify remote service provider		
	}
	
	public function SyncAccounts()
	{
		//update all user_info fields
		//if cannot read user's info , then delete the association
	}
}
?>