<?php 
include_once 'AppListForm.php';
class InstalledAppListForm extends AppListForm
{	
	public function fetchDataSet()
	{
		$resultSet = parent::_fetchDataSet();		
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
		return $newResultSet;
		
	}	
}
?>