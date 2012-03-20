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
	
	public function fetchDataSet()
	{

        if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
            $searchRule = $this->m_SearchRule;          
	}
	
	public function sortRecord($sortCol, $order='ASC')
    {
        $element = $this->getElement($sortCol);
        // turn off the OnSort flag of the old onsort field
        $element->setSortFlag(null);
        // turn on the OnSort flag of the new onsort field
        if ($order == "ASC")
            $order = "DESC";
        else
            $order = "ASC";
        $element->setSortFlag($order);

        // change the sort rule and issue the query
        $this->m_SortRule="[" . $element->m_FieldName . "] $order";

        // move to 1st page
        $this->m_CurrentPage = 1;
        //$this->m_SortRule = "";

        $this->rerender();
    }	
}
?>