<?php 
include_once 'AppListForm.php';
class FeatureAppListForm extends AppListForm
{
	
	
	public function fetchDataSet()
	{
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultSet = array();
		$repoList = $this->fetchRepoList();
		foreach($repoList as $repoServer)
		{
			$repo_uri = $repoServer['repository_uri'];
			$appList = $svc->discoverFeaturedApps($repo_uri);
			foreach($appList as $appInfo)
			{
				$resultSet[] = $appInfo;
			}	
		}
		return $resultSet;
	}
}
?>