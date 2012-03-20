<?php 
class AppListForm extends EasyForm
{
	public $m_RepoDO = "market.repository.do.RepositoryDO";
	
	protected function getDefaultRepoURI()
	{
		if($_POST['fld_repo_id'])
    	{
    		$repoRec = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchById((int)$_POST['fld_repo_id']);
    	}else
    	{
    		$repoRec = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchOne("[status]=1");    	
    	}
    	$repo_uri = $repoRec['repository_uri'];	
    	return $repo_uri;	
	}
	
	protected function fetchRepoList()
	{
		$rs = BizSystem::getObject($this->m_RepoDO)->directFetch("[status]='1'");
		return $rs;
	}
}
?>