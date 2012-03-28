<?php 
class NotificationService extends MetaObject
{
	protected $m_InstalledDO = "market.installed.do.InstalledDO";
	
	public function checkNotification()
	{
		$notificationList = array();
		$msgList = $this->_checkAppUpdate();
		foreach ($msgList as $msg)
		{
			$notificationList[] = $msg;
		}
		
		$msgList = $this->_checkAppRelease();
		foreach ($msgList as $msg)
		{
			$notificationList[] = $msg;
		}
		
		$msgList = $this->_checkAppInfo();
		foreach ($msgList as $msg)
		{
			$notificationList[] = $msg;
		}		
		return $notificationList;
	}
	
	protected function _checkAppUpdate()
	{
		
		$resultSet = BizSystem::getObject($this->m_InstalledDO)->directfetch();
		//below code copied from appUpdateListFrom
		$repoAppsArr = array();
		$repoIdsArr = array();
		$AppsInfoArr = array();		
		if(!$resultSet)
		{
			return ;
		}
		$svc = BizSystem::getService("market.lib.PackageService");
		
		foreach ($resultSet as $record)
		{
			$repoAppsArr[$record['repository_uid']][] = $record['app_id'];
		}
		foreach ($repoAppsArr as $repo_uid=>$apps)
		{	
			if($repo_uid){		
				$repoInfo = $this->getRepoInfo($repo_uid);
				$repo_url = $repoInfo['repository_uri'];				
				$repoIdsArr[$repo_uid]= $repoInfo['Id'];
				$appList = $svc->discoverAppList($repo_url,$apps);
				if(is_array($appList)){
					foreach ($appList as $appInfo){
						$appInfo['icon'] = $repo_url.$appInfo['icon'];
						$AppsInfoArr[$repo_uid][$appInfo['Id']] = $appInfo;
					}	
				}
			}		
		}
		$newResultSet = array();
		foreach($resultSet as $key=>$value)
		{
			$appInfo = $AppsInfoArr[$value['repository_uid']][$value['app_id']];
			$value['repo_id'] = $repoIdsArr[$value['repository_uid']]; 			
			foreach($appInfo as $app_key => $app_value)
			{
				$value[$app_key] = $app_value;
			}
			$newResultSet[$key] = $value;
		}
		
		foreach($newResultSet as $key=>$app)
		{			
			$current_version = $app['version'];
			$latest_version = $app['latest_version'];
			if(version_compare($current_version, $latest_version) != -1)
			{
				unset($resultSet[$key]);
			}else{
				$app['description'] = $app['version_description'];
				$resultSet[$key] = $app;
			}
		}	
		//above code copied from appUpdateListFrom
		if(count($resultSet))
		{			
			$msg['type']='new_app_update';
			$msg['subject']='Found New Application Update !';
			$msg['message']='Please notice your system administrator to update installed applications by using Openbiz Market.';
			$msg['read_access']="";
			$msg['update_access']="Market.Manage";			
			return array($msg);
		}		
		return null;
	}
	
	protected function _checkAppRelease()
	{
		if(count($resultSet))
		{
			$msg['type']='new_app_update';
			$msg['subject']='new_app_update';
			$msg['message']='new_app_update';
			return $msg;
		}
		return $msg;
	}
	
	protected function _checkAppInfo()
	{
		$msg['type']='new_app_info';
		//return $msg;
	}
	
}
?>