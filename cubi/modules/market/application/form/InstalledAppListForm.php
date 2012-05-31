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
			if(is_array($appInfo)){
				foreach($appInfo as $app_key => $app_value)
				{
					$value[$app_key] = $app_value;
				}
				$newResultSet[$key] = $value;
			}
		}
		return $newResultSet;
		
	}	
}
?>