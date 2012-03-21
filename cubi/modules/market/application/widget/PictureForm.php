<?php 
require_once(dirname(dirname(__FILE__)).'/form/AppListForm.php');
class PictureForm extends AppListForm
{
	public function fetchDataSet()
	{
		$resultSet = array();
		$app_id = (int)$_GET['fld:Id'];
		$repo_uri = $this->getDefaultRepoURI();
		
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultRecords = $svc->discoverAppPics($repo_uri,$app_id);
		foreach($resultRecords as $record)
       	{
       		$record['url'] = $repo_uri.$record['url'];
       		$resultSet[] = $record;
       	}		
		return $resultSet;
	}
}
?>