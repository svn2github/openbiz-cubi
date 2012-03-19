<?php 
include_once 'AppListForm.php';
class ApplicationsListForm extends AppListForm
{
	public function fetchDataSet()
	{
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultSet = array();
		$repoList = $this->fetchRepoList();
		foreach($repoList as $repoServer)
		{
			$repo_uri = $repoServer['repository_uri'];
			$appList = $svc->discoverApplication($repo_uri,$cat_id);	
			if(is_array($appList)){
				foreach($appList as $appInfo)
				{
					$resultSet[strtotime($appInfo['release_time'])] = $appInfo;
				}	
			}
		}
		//mix all data by release date
		krsort($resultSet);
		
		$resultSetF = array();
		foreach($resultSet as $rec)
		{
			$resultSetF[] = $rec;
		}
		return $resultSetF;
	}
}
?>