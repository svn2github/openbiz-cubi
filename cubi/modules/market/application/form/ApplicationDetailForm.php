<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.application.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

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
			$appInfo['version_description'] = $releaseInfo['description'];
		}
		
		BizSystem::getService(ACL_SERVICE)->clearACLCache();
		return $appInfo;
	}
	
	public function deleteRecord($id)
	{
    	$RecordIds = explode(":", $id);
   		$app_id = $RecordIds[0];
   		$repo_id = $RecordIds[1];			
   		$this->uninstall($repo_id, $app_id);   		
   		$this->processPostAction();
	}
	
	public function uninstall($repo_id,$app_id){
		$svc = BizSystem::getService("market.lib.PackageService");
   		$repoInfo = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchById($repo_id);
   		$repo_uri = $repoInfo->repository_uri;
   		$repo_uid = $repoInfo->repository_uid;
   		
   		//get app module
   		$appInfo = $svc->discoverAppInfo($repo_uri,$app_id);
   		$app_uid = $appInfo['package_id'];
   		
   		//only application allow to uninstall
   		if(preg_match("/com.application/si",strtolower($app_uid))){
   			$moduleName = str_replace("com.application.", "", strtolower($app_uid));	   		
	   		//unload module
	   		include_once MODULE_PATH."/system/lib/ModuleUnloader.php";
	   		$loader = new ModuleUnloader($moduleName);
	        $loader->debug = false;
	        $loader->unLoadModule();   		   		
   		
	   		//delete installed record
	   		$searchRule = "[app_id]='$app_id' AND [repository_uid]='$repo_uid'";
			BizSystem::getObject("market.installed.do.InstalledDO")->deleteRecords($searchRule);		
   		}		
	}
	
	public function allowUninstall($repo_id,$app_id){
		$svc = BizSystem::getService("market.lib.PackageService");
   		$repoInfo = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchById($repo_id);
   		$repo_uri = $repoInfo->repository_uri;
   		$repo_uid = $repoInfo->repository_uid;
   		
   		//get app module
   		$appInfo = $svc->discoverAppInfo($repo_uri,$app_id);
   		$app_uid = $appInfo['package_id'];
   		if(preg_match("/com.application/si",strtolower($app_uid))){
   			return true;
   		}else{
   			return false;
   		}
	}
	
	public function CallInstallerForm($formName,$param)
	{
		if(function_exists("curl_init"))
		{
			return $this->loadDialog($formName,$param);
		}
		else
		{
			return $this->loadDialog("market.application.form.CURLModuleNotInstalled");
		}
	}
}
?>