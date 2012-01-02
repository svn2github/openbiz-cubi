<?php
class PackageLocalForm extends EasyForm 
{ 
	
	public $m_InstallState = false;
	public $m_hasUpagrade = false;
	
    public function validateRequest($methodName)
    {
        if ($methodName == "getProgress") return true;
        return parent::validateRequest($methodName);
    }
    
    public function fetchData()
    {
    		$result = parent::fetchData();
    		$result['install_download'] = 0;
    		switch(strtoupper($result['inst_state']))
    		{
    			default:
    			case "ERROR":
    				$result['install_progress'] = '0';
    				$result['install_download'] = '0';
    				break;
    			case "DOWNLOAD":
    				$result['install_progress'] = '20';
                    if ($dataRec['inst_filesize'] == 0) $updArray['fld_download_progress'] = '0';
                    else $updArray['fld_download_progress'] = (int)(($dataRec['inst_download'] / $dataRec['inst_filesize'])*100);     	
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
    		//$result['install_status'] = 'Stand by.';
            //	var_dump((int)(($result['inst_download'])/$result['inst_filesize']*100));exit;    				
    		
    		$state = $result['inst_state'] ? $result['inst_state'] : "Wait";
        	$log = $result['inst_log'] ? $result['inst_log'] : "Waiting...";
        	//$result['install_status'] =  $log;
    		
        	if($result['inst_version'] && $result['inst_time']){
        		$this->m_InstallState = 1;
        	}else{
        		$this->m_InstallState = 0;
        	}
        	if($result['inst_version']< $result['version'])
        	{
        		$this->m_hasUpagrade = 1;
        	}else{
        		$this->m_hasUpagrade = 0;
        	}
    		return $result ;
    	
    }
    
    public function reload()
    {
        $packageService = "package.lib.PackageService";
        // get package service 
        $pkgsvc = BizSystem::GetObject($packageService);
        $packages = $pkgsvc->discoverPackages();
        
        $this->resetSearch();
    }
    
    public function install($id)
    {
        $dataRec = $this->getDataObj()->fetchById($id);
        $pkgname = $dataRec['name'];
        $this->m_RecordId = $id;
        try {
            //$cmd = PHP_EXE." ".APP_HOME.DIRECTORY_SEPARATOR."bin".DIRECTORY_SEPARATOR."tools".DIRECTORY_SEPARATOR."install_pkg.php $pkgname";
            //$cmd = PHP_EXE." ".APP_HOME.DIRECTORY_SEPARATOR."bin".DIRECTORY_SEPARATOR."tools".DIRECTORY_SEPARATOR."test.php";
            //echo $cmd;
            //background_exec($cmd);        
            
            session_write_close();  // close session to unblock other ajax calls
            // start download
            $packageService = "package.lib.PackageService";
            // get package service 
            $pkgsvc = BizSystem::GetObject($packageService);
            $filename = $pkgsvc->downloadPackage($pkgname);
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
        $state = $dataRec['inst_state'] ? $dataRec['inst_state'] : "Wait";
        $log = $dataRec['inst_log'] ? $dataRec['inst_log'] : "Waiting...";
        $progress = $state . "|". $log;
        $updArray['fld_status'] = $progress;
        
        switch(strtoupper($dataRec['inst_state']))
        {
            default:
            case "ERROR":
                $updArray['fld_total_progress'] = '0';
                $updArray['fld_download_progress'] = '0';
                break;
            case "DOWNLOAD":
                $updArray['fld_total_progress'] = '20';
                if ($dataRec['inst_filesize'] == 0) $updArray['fld_download_progress'] = '0';
                else $updArray['fld_download_progress'] = (int)(($dataRec['inst_download'] / $dataRec['inst_filesize'])*100);     	
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
        /*
        $script = "Openbiz.ProgressBar.set('progress_bar','$progress');"; // $func";
        BizSystem::clientProxy()->runClientFunction($script);
        */
        
        BizSystem::clientProxy()->updateFormElements($this->m_Name, $updArray);
        
        //$this->updateForm();
        return;
    }
    
    public function uninstall($id)
    {
        // remove the package from the installed location
        
        // remove the inst_... from local package table
        
    }
    
}

?>