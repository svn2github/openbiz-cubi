<?php 
include_once 'AppListForm.php';
class FeaturedAppsListForm extends AppListForm
{
	
	
	public function fetchDataSet()
	{
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultSet = array();
		$repo_uri = $this->getDefaultRepoURI();
					
		$appList = $svc->discoverFeaturedApps($repo_uri);	
		if(is_array($appList)){
			foreach($appList as $appInfo)
			{
				$resultSet[strtotime($appInfo['release_time'])] = $appInfo;
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