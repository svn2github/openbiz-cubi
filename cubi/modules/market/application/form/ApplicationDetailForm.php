<?php 
require_once 'AppListForm.php';
class ApplicationDetailForm extends AppListForm
{
	public function fetchData()
	{
		$app_id = (int)$_GET['fld:Id'];
		$repo_uri = $this->getDefaultRepoURI();
		
		$svc = BizSystem::getService("market.lib.PackageService");
		$appInfo = $svc->discoverAppInfo($repo_uri,$app_id);
		$this->m_RecordId = $appInfo['Id'];
		$appInfo['icon'] = $repo_uri.$appInfo['icon'];
		return $appInfo;
	}
}
?>