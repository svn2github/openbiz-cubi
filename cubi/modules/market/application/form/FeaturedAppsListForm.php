<?php 
include_once 'AppListForm.php';
class FeaturedAppsListForm extends AppListForm
{
	
	
	public function fetchDataSet()
	{
		parent::fetchDataSet();				
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultSet = array();
				
		$repo_uri = $this->getDefaultRepoURI();	
		$params=array(
			"sortRule" => $this->m_SortRule,
			"searchRule" => $searchRule,
			"range" => $this->m_Range,
			"startItem" => ($this->m_CurrentPage-1)*$this->m_Range
		);
		$appList = $svc->discoverFeaturedApps($repo_uri,$params);	
		if(is_array($appList['data'])){
			foreach($appList['data'] as $appInfo)
			{
				$appInfo['icon'] = $repo_uri.$appInfo['icon'];
				$resultSet[] = $appInfo;
			}
		}		
        $this->m_TotalRecords = $appList['totalRecords'];
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		
		return $resultSet;
	}
}
?>