<?php 
class RepositoryForm extends EasyForm
{
	public $m_RepoValidated = 'N';
	protected $m_RepoInfo = array();
	
	public function checkRepo()
	{
		$rec= $this->readInputRecord();
		$repo_uri = $rec['repository_uri'];
		$svc = BizSystem::getService("market.lib.PackageService");
		$repoInfo = $svc->discoverRepository($repo_uri);
		if(!count($repoInfo))
		{
			$this->m_Errors = array(
        		"fld_uri"=> $this->getMessage("REPO_INVALID")
        	);
        	$recArr = $this->readInputRecord();
       		$this->setActiveRecord($recArr);
        	$this->processFormObjError($this->m_Errors);
           	return false;
		}
		$this->m_RepoInfo = $repoInfo;
		$this->m_RepoValidated = 'Y';
		$this->updateForm();
	}
	
	public function fetchData()
	{
		$result = parent::fetchData();
		
		if(count($this->m_RepoInfo)==0 && $result['repository_uri']!=''){
			$repo_uri = $result['repository_uri'];
			$svc = BizSystem::getService("market.lib.PackageService");
			$this->m_RepoInfo = $svc->discoverRepository($repo_uri);
		}
		
		if(is_array($this->m_RepoInfo)){
			foreach($this->m_RepoInfo as $key => $value)
			{
				$result[$key] = $value;
			}
		}
		return $result;
	}
}
?>