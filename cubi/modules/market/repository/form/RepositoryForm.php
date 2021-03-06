<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.repository.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

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
		
		if(count($this->m_RepoInfo)==0 && $result['repository_uri']!='' && $result['repository_uri']!='http://'){
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
	
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		$svc = BizSystem::getService("market.lib.PackageService");
		foreach($resultSet as $key=>$record)
		{
			$repo_uri = $record['repository_uri'];
			$repoInfo = $svc->discoverRepository($repo_uri);
			$record['repository_name'] = $repoInfo['_repo_name'];
			$resultSet[$key] = $record;
		}
		return $resultSet;
	}
	
	public function insertRecord()
	{
		
		$recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }

		$repo_uri = $recArr['repository_uri'];
		$svc = BizSystem::getService("market.lib.PackageService");
		$repoInfo = $svc->discoverRepository($repo_uri);        
        $recArr['repository_uid'] = $repoInfo['_repo_uid'];
        $recArr['repository_name'] = $repoInfo['_repo_name'];
        $this->_doInsert($recArr);
        
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();
	
	}
}
?>