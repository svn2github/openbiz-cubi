<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */
set_time_limit(0);
require_once "PackageService.php";

class InstallerService extends PackageService
{
	
	protected $_installPackage = "";
	protected $_repoUri = "";
	const INSTALLED_DO = "market.installed.do.InstalledDO";
			
	public function getRepoUID($uri)
	{
		$uri = addslashes($uri);
		$repoRec = BizSystem::getObject("market.repository.do.RepositoryDO")->fetchOne("[repository_uri]='$uri'");
		if($repoRec)
		{
			
			return $repoRec['repository_uid'];
		}
	}
	
    public function downloadPackage($uri, $app_id)
    {        
        $pkg = $this->discoverAppLatestRelease($uri,$app_id);
        $this->_repoUri = $uri;
        
        if (!$pkg) { 
            return null;
        }
        $this->pkg_log(">>> Package: ".$pkg['app_id'].", ".$pkg['filename'].", ".$pkg['version'].", ".$pkg['url']."\n");
        
        $repo_uid = $this->getRepoUID($uri);
        $pkg['repository_uid'] = $repo_uid; 
        
        $this->_installPackage = $pkg;
        try {
            $this->setInstallInfo($pkg, array("version"=>$pkg['version'],"state"=>"Start"));
    	           
            $url = $uri.$pkg['url'];
            if (empty($url)) {
                $this->setInstallInfo($package, array("state"=>"ERROR","log"=>"Unable to install from empty url."));
                return false;
            }
            $file_dir = APP_FILE_PATH.DIRECTORY_SEPARATOR."tmpFiles".DIRECTORY_SEPARATOR;
            if(!is_dir($file_dir)){
	            mkdir($file_dir,0777);
            }
            $filename = $file_dir.basename($pkg['url']);
            $this->pkg_log("Downloading from $url ...\n");
            $this->downloadUrl($url, $filename);
            $this->pkg_log("Completed download from $url ...\n");

            $this->installPackage($filename);
          
            
            if (file_exists($filename)) {
                return $filename;
            }
            else {
                return null;
            }
        }
        catch (Exception $e) {
            $msg = $e->getMessage();
            $this->setInstallInfo($package, array("state"=>"ERROR","log"=>$msg));
        }
    }	
    

	protected function downloadUrl($url, $filename)
    {
    	$package = $this->_installPackage;
        
        //clean setting for counting download, filesize, download size
    	$this->setInstallInfo($package, array("filesize"=>"0" , "download"=>"0"));
    	
    	$filesize = $this->_remote_filesize($url);
    	$this->setInstallInfo($package, array("filesize"=>$filesize , "download"=>"0"));
    	
        $this->setInstallInfo($package, array("state"=>"Download","log"=>"Downloading 0..."));
        $handle = fopen($url, "rb");
        if (!$handle) {
            $this->setInstallInfo($package, array("state"=>"ERROR","log"=>"Unable to open url $url"));
            throw new Exception("Unable to open url $url");
        }
        $fp = fopen($filename, "wb");
        if (!$fp) {
            $this->setInstallInfo($package, array("state"=>"ERROR","log"=>"nable to open file $filename"));
            throw new Exception("Unable to open file $filename");
        }
        $total = 0;
        $contents = '';
        $utilService = BizSystem::getService("service.utilService");
        while (!feof($handle)) {
            $contents = fread($handle, 8192);
            $result = fwrite($fp, $contents);
            $total += strlen($contents);
            $this->setInstallInfo($package, array("log"=>"Downloading ".$utilService->format_bytes($total)." of ".$utilService->format_bytes($filesize)." ...","filesize"=>$filesize ,"download"=>$total));
            $this->pkg_log("Downloading ".$utilService->format_bytes($total)." of ".$utilService->format_bytes($filesize)."\n");
            //sleep(2);
        }
        fclose($handle);
        fclose($fp);
    }      
    
    
    protected function _remote_filesize($url, $user = "", $pw = "")
    {
	    ob_start();
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	
	    if(!empty($user) && !empty($pw))
	    {
	    $headers = array('Authorization: Basic ' .  base64_encode("$user:$pw"));
	    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    }
	
	    $ok = curl_exec($ch);
	    curl_close($ch);
	    $head = ob_get_contents();
	    ob_end_clean();
	
	        	
	    $regex = '/Content-Length:\s([0-9]+)/si';
	    $count = preg_match($regex, $head, $matches);
	    return isset($matches[1])?$matches[1]:'unknown';
    }    
    

    protected function _unpack($tarfile, $toFolder)
    {
        // include PEAR Tar class
        set_include_path(get_include_path(). PATH_SEPARATOR . APP_HOME."/bin/phing/classes");
        include_once(APP_HOME."/bin/phing/classes/Archive/Tar.php");
        if (!class_exists('Archive_Tar')) {
            throw new Exception("You must have installed the PEAR Archive_Tar class in order to use UntarTask.");
        }
        $tar = $this->_initTar($tarfile);
        $result = $tar->extract($toFolder);
        if (!$result) {
            throw new Exception("Could not extract tar file: $tarfile");
        }
    }    
    
    protected function _filecopy($tmpFolder)
    {
        $dir0s = ob_scandir($tmpFolder);
        // copy module to cubi/upgrade folder
        foreach ($dir0s as $dir0) {
            $dirs = ob_scandir($tmpFolder."/$dir0");
            foreach ($dirs as $dir) {
                $srcDir = $tmpFolder."/$dir0/$dir";
                $dstDir = ($dir == 'modules') ? APP_HOME."/upgrade/modules" : APP_HOME."/$dir";
                $this->pkg_log("copy $srcDir to $dstDir \n");
                recurse_copy($srcDir, $dstDir);
                if ($dir == 'modules')
                    $this->_installModules = ob_scandir($srcDir);
            }
        }    
    }
        
    private function _initTar($tarfile)
    {
        $compression = null;
        $tarfileName = basename($tarfile);
        $mode = strtolower(substr($tarfileName, strrpos($tarfileName, '.')));
        if ($mode == ".cpk")
            $mode = ".gz";

        $compressions = array(
                'gz' => array('.gz', '.tgz',),
                'bz2' => array('.bz2',),
            );
        foreach ($compressions as $algo => $ext) {
            if (array_search($mode, $ext) !== false) {
                $compression = $algo;
                break;
            }
        }
        return new Archive_Tar($tarfile, $compression);
    }    
    
    public function installPackage($cpkFilePath)
    {   
        $package = $this->_installPackage;
        $uri = $this->_repoUri;
        $this->setInstallInfo($package, array("state"=>"Install","log"=>"Installing ..."));

		//trigger remote log action      
        $operator = BizSystem::GetProfileName(BizSystem::getUserProfile("Id"),'short');  
        $app_id = $package['app_id'];
        $release_id = $package['Id'];
        $this->recordInstallLog($uri,$app_id,$release_id,SITE_URL,$operator);              
        
        $tmpFolder = APP_FILE_PATH.DIRECTORY_SEPARATOR."tmpfiles".DIRECTORY_SEPARATOR;
        $toFolder = $tmpFolder.time();
 
        try {
            $this->_unpack($cpkFilePath, $toFolder);
        }
        catch (Exception $e) {
            throw new Exception("ERROR in unpack $cpkFilePath. ".$e->getMessage());
        }
        $this->pkg_log("Unpack. $cpkFilePath is unpacked to $toFolder\n");
        
        // copy files to target folder from the tmp folder
        $this->_filecopy($toFolder);
        
        if(strtolower($package['type'])=='module' || strtolower($package['type'])=='application')
        {
	        // invoke module upgrade command
	        foreach ($this->_installModules as $moduleName) {
	            $this->pkg_log("invoke module upgrade command\n");        
	            $loader = new ModuleLoader($moduleName);
	            
		        $loader->debug = 0;
		        $this->pkg_log("Start upgrading $moduleName module ...".PHP_EOL);
	            $this->pkg_log("--------------------------------------------------------".PHP_EOL);
		        $result = $loader->upgradeModule(true);
		        $this->pkg_log($loader->errors . "".PHP_EOL);
		        $this->pkg_log($loader->logs . "".PHP_EOL);
		        if ($result == false) {
		            throw new Exception("Error in install package. ".$loader->errors);
		        }
	            
	            
	            // load the module again
	            $this->pkg_log("Reload module ...".PHP_EOL);
	            $loader->loadModule($installSql);
	            $this->pkg_log($loader->errors . "".PHP_EOL);
	        }
        }
        $time = date('Y-m-d H:i:s');

        //reload current profile
        BizSystem::getService(ACL_SERVICE)->clearACLCache();

        $this->setInstallInfo($package, array("time"=>$time,"version"=>$package['version'],"state"=>"OK","log"=>"Completed"));
    }    
    
    protected function recordInstallLog($uri,$app_id,$release_id,$siteurl,$operator)
    {
    	$params['app_id'] = $app_id;
    	$params['release_id'] = $release_id;
    	$params['siteurl'] = $siteurl;
    	$params['operator'] = $operator;
		return $this->_remoteCall($uri,'recordInstallLog',$params);
    }
    
    protected function setInstallInfo($pkgArr,$installInfo)
    {	                                	
        $pkgDo = BizSystem::GetObject(self::INSTALLED_DO);        
        $searchRule = " [app_id]='".$pkgArr['app_id']."' AND         				
        				[repository_uid]='".$pkgArr['repository_uid']."' 
        				";
        $dataRec = $pkgDo->fetchOne($searchRule);        
        
        if (!$dataRec){        	
        	$dataRec = new DataRecord(null,$pkgDo);
        	$dataRec["app_id"] = $pkgArr['app_id'];
        	$dataRec["version"] = $pkgArr['version'];
        	$dataRec["repository_uid"] = $pkgArr['repository_uid'];
        	        	
        }
				
        if (isset($installInfo['version'])) $dataRec["version"] = $installInfo['version'];
        if (isset($installInfo['time'])) $dataRec["install_time"] = $installInfo['time'];
        if (isset($installInfo['state'])) $dataRec["install_state"] = $installInfo['state'];
        if (isset($installInfo['log'])) $dataRec["install_log"] = $installInfo['log'];

        if (isset($installInfo['filesize'])) $dataRec["install_download_filesize"] = $installInfo['filesize'];
        if (isset($installInfo['download'])) $dataRec["install_download"] = $installInfo['download'];

        try {
            $dataRec->save();            
        }
        catch (Exception $e) {
            throw new Exception("setInstallInfo. Unable to save the record. ".$e->getMessage());
        }
        return true;
    }    
    
      
	
	function pkg_log($text)
	{
	    if (CLI) echo $text.nl;
	    //BizSystem::log(LO_ERR, "ECHO", $text);
	    $logfile = LOG_PATH."/INSTALL_PKG.log";
	    $fp = fopen($logfile, "a+");
	    fwrite($fp, date('c')." ".$text);
	    fclose($fp);
	} 

}


?>