<?php 
class AppListForm extends EasyForm
{
	public $m_RepoDO = "market.repository.do.RepositoryDO";
	
	protected function fetchRepoList()
	{
		$rs = BizSystem::getObject($this->m_RepoDO)->directFetch("[status]='1'");
		return $rs;
	}
}
?>