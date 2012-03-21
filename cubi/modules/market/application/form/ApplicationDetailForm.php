<?php 
require_once 'AppListForm.php';
class ApplicationDetailForm extends AppListForm
{
	public function fetchData()
	{
		$app_id = (int)$_GET['fld:Id'];
		$repo_uri = $this->getDefaultRepoURI();
		
		$svc = BizSystem::getService("market.lib.PackageService");
		$util = BizSystem::getService(UTIL_SERVICE);
		
		$appInfo = $svc->discoverAppInfo($repo_uri,$app_id);
		$this->m_RecordId = $appInfo['Id'];
		$appInfo['icon'] = $repo_uri.$appInfo['icon'];
		
		$releaseInfo = $svc->discoverAppLatestRelease($repo_uri,$app_id);
		if($releaseInfo){
			$releaseInfo['url']= $repo_uri.$releaseInfo['url'];
			$releaseInfo['create_date'] = date("Y-m-d",strtotime($releaseInfo['create_time']));
			$releaseInfo['filesize'] = $util->format_bytes($releaseInfo['filesize']);
			$appInfo['latest_release'] = $releaseInfo;
		}
		return $appInfo;
	}
}
?>