<?php 
class RepositoryForm extends EasyForm
{
	public $m_RepoValidated = 'N';
	
	public function checkRepo()
	{
		$rec= $this->readInputRecord();
		$repo_uri = $rec['repository_uri'];
		$this->m_RepoValidated = 'Y';
		$this->rerender();
	}
}
?>