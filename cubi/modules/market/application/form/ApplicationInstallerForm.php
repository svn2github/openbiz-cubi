<?php
class ApplicationInstallerForm extends EasyForm 
{ 
	
	public $m_InstallState = false;
	public $m_hasUpagrade = false;
	public $m_AppIcon;
	public $m_AppReleaseDate;
	
	public $m_InstallDO = "market.installed.do.InstalledDO";
	
    public function validateRequest($methodName)
    {
        if ($methodName == "getProgress") return true;
        return parent::validateRequest($methodName);
    }
    

    public function outputAttrs()
    {
    	$result = parent::outputAttrs();
    	$result['remote_icon'] = $this->m_AppIcon;
    	$result['release_date'] = $this->m_AppReleaseDate;
    	return $result;
    }

      
    public function fetchData()
    {
   		$RecordIds = $this->m_RecordId;
    	$RecordIds = explode(":", $RecordIds);
   		$app_id = $RecordIds[0];
   		$repo_id = $RecordIds[1];
    	$repoRec = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchOne("[status]=1 AND [Id]='$repo_id'");
    	$repo_uri = $repoRec['repository_uri'];
    	$svc = BizSystem::getService("market.lib.PackageService");
    	$result = $svc->discoverAppInfo($repo_uri,$app_id);
    	$this->m_AppIcon = $repo_uri.$result['icon'];
    	$this->m_AppReleaseDate = date('Y-m-d',strtotime($result['release_time']));
    	 
    	
    	
    	$installRec = BizSystem::getObject($this->m_InstallDO)->fetchOne("[app_id]='$app_id'");
    	if($installRec)
    	{
    		foreach($installRec as $key=>$value)
    		{
    			$result[$key]=$value;
    		}
    	}
    	
    	$result["Id"] = $this->m_RecordId;
    	$result['install_download'] = 0;
    	switch(strtoupper($result['install_state']))
    	{
    		default:
    		case "ERROR":
    			$result['install_progress'] = '0';
    			$result['install_download'] = '0';
    			break;
    		case "DOWNLOAD":
    			$result['install_progress'] = '20';
                if ($result['install_download_filesize'] == 0) $result['fld_download_progress'] = '0';
                else $updArray['fld_download_progress'] = (int)(($dataRec['install_download'] / $dataRec['install_download_filesize'])*100);     	
    			break;    			
    		case "INSTALL":
    			$result['install_progress'] = '60';
    			$result['install_download'] = '100';
    			break;
    		case "OK":
    			$result['install_progress'] = '100';
    			$result['install_download'] = '100';
    			break;	
    	}
    		
    	$state = $result['install_state'] ? $result['install_state'] : "Wait";
        $log = $result['install_log'] ? $result['install_log'] : "Waiting...";

        $this->m_InstallState = $this->getInstallState($repo_uri,$app_id);
        $this->m_hasUpagrade = $this->hasUpgrade($repo_uri,$app_id);
        
    	return $result ;
    	
    }
        
    protected function getInstallState($repo_url,$app_id)
    {
    	$svc = BizSystem::getService("market.lib.InstallerService");
    	$repo_uid = $svc->getRepoUID($repo_url);
    	$searchRule = " [install_state]='OK' AND 
    					[app_id]='$app_id' AND
    					[repository_uid] = '$repo_uid'
    					";
    	$instRec = $this->getDataObj()->fetchOne($searchRule);
    	if($instRec){
    		return true;
    	}else{
    		return false;
    	}
    }
    
	protected function hasUpgrade($repo_url,$app_id)
    {
    	
    }
    
    public function install($id)
    {
    	$RecordIds = $this->m_RecordId;
    	$RecordIds = explode(":", $RecordIds);
   		$app_id = $RecordIds[0];
   		$repo_id = $RecordIds[1];
    	$repoRec = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchOne("[status]=1 AND [Id]='$repo_id'");
    	$repo_uri = $repoRec['repository_uri'];
    	$svc = BizSystem::getService("market.lib.PackageService");
    	$result = $svc->discoverAppInfo($repo_uri,$app_id);
    	        
        $this->m_RecordId = $id;
        try {            
            session_write_close();  // close session to unblock other ajax calls
            $packageService = "market.lib.InstallerService";
            $pkgsvc = BizSystem::GetObject($packageService);
            $filename = $pkgsvc->downloadPackage($repo_uri,$app_id);
        }
        catch (Exception $e) {
            $errors = array($e->getMessage());
            $this->processFormObjError($errors);
            return;
        }
    }
    
    public function getProgress($id=null)
    {
        if ($id==null || $id=='')   $id = $this->m_RecordId;
        $dataRec = $this->getDataObj()->fetchById($id);
        $state = $dataRec['install_state'] ? $dataRec['install_state'] : "Wait";
        $log = $dataRec['install_log'] ? $dataRec['install_log'] : "Waiting...";
        $progress = $state . "|". $log;
        $updArray['fld_status'] = $progress;
        
        switch(strtoupper($dataRec['install_state']))
        {
            default:
            case "ERROR":
                $updArray['fld_total_progress'] = '0';
                $updArray['fld_download_progress'] = '0';
                break;
            case "DOWNLOAD":
                $updArray['fld_total_progress'] = '20';
                if ($dataRec['install_download_filesize'] == 0) $updArray['fld_download_progress'] = '0';
                else $updArray['fld_download_progress'] = (int)(($dataRec['install_download'] / $dataRec['install_download_filesize'])*100);     	
                break;    			
            case "INSTALL":
                $updArray['fld_total_progress'] = '60';
                $updArray['fld_download_progress'] = '100';
                break;
            case "OK":
                $updArray['fld_total_progress'] = '100';
                $updArray['fld_download_progress'] = '100';
                break;	
        }
        
        BizSystem::clientProxy()->updateFormElements($this->m_Name, $updArray);       
        return;
    }
    
    public function uninstall($id)
    {
        // remove the package from the installed location
        
        // remove the inst_... from local package table
        
    }
    
}

?>