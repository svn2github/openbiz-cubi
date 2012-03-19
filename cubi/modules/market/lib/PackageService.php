<?php 
include_once(MODULE_PATH."/common/lib/fileUtil.php");
include_once(MODULE_PATH."/common/lib/httpClient.php");
include_once(MODULE_PATH."/system/lib/ModuleLoader.php");

class PackageService extends MetaObject
{
	
	public function discoverFeaturedApps($uri)
	{
		return $this->_remoteCall($uri,'fetchFeaturedApps');
	}	
	
	public function discoverRepository($uri)
	{
		return $this->_remoteCall($uri,'fetchRepoInfo');
	}
	
	public function discoverApplication($uri,$cat_id)
	{
		if($cat_id){
			$param=array("cat_id"=>$cat_id);
		}
		return $this->_remoteCall($uri,'fetchApplications',$param);
	}	
	
	protected function _remoteCall($uri,$method,$params=null)
    {
        $cache_id = md5($this->m_Name.$uri. $method .serialize($params));         
        $cacheSvc = BizSystem::getService(CACHE_SERVICE,1);
        $cacheSvc->init($this->m_Name,$this->m_CacheLifeTime);
        if(substr($uri,strlen($uri)-1,1)!='/'){
        	$uri .= '/';
        }		
        $uri .= "ws.php/repository/RepositoryService";               
        if($cacheSvc->test($cache_id) && (int) $this->m_CacheLifeTime>0)
        {
            $resultSetArray = $cacheSvc->load($cache_id);
        }else{
        	try{        		
		        $argsJson = json_encode($params);
        		$query = array(	"method=$method","format=json","argsJson=$argsJson");
		        
		        $httpClient = new HttpClient('POST');
		        foreach ($query as $q)
		            $httpClient->addQuery($q);
		        $headerList = array();
		        $out = $httpClient->fetchContents($uri, $headerList);
		        $cats = json_decode($out, true);
		        $resultSetArray = $cats['data'];
		        $cacheSvc->save($resultSetArray,$cache_id);
        	}
        	catch(Exception $e)
        	{
        		$resultSetArray = array();
        	}
        }        
        return $resultSetArray;
    }
    
    /*
     * Old service code
     * ==================================================================================
     * */
	
    protected $_installPackage = "";
    protected $_installModules = array();
    
    public $m_CacheLifeTime = null;	
    
    const LOCAL_PACKAGE_DO = "package.local.do.PackageLocalDO";

    public $repositoryUrl; // repository url
    
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    } 
       	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetadata($xmlArr);
        $this->m_CacheLifeTime = isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["CACHELIFETIME"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["CACHELIFETIME"] : "0";
    	$this->repositoryUrl = isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REPOSITORYURL"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REPOSITORYURL"] : "";
    }
    
	
    
    public function discoverCategories()
    {
        $cache_id = md5($this->m_Name . "discoverCategories");
        //try to process cache service.
        $cacheSvc = BizSystem::getService(CACHE_SERVICE,1);
        $cacheSvc->init($this->m_Name,$this->m_CacheLifeTime);
        if($cacheSvc->test($cache_id))
        {
            //BizSystem::log(LOG_DEBUG, "DATAOBJ", "Cache Hit. Query Sql = ".$sql." BIND: $bindValueString");
            $resultSetArray = $cacheSvc->load($cache_id);
        }else{
	    	
	        $argsJson = json_encode(array("searchrule"=>"","limit"=>-1));
	        $query = array(	"method=list_categories","format=json",
	                        "argsJson=$argsJson");
	        $httpClient = new HttpClient('POST');
	        foreach ($query as $q)
	            $httpClient->addQuery($q);
	        $headerList = array();
	        $out = $httpClient->fetchContents($this->repositoryUrl, $headerList);
	        //echo $out;
	        $cats = json_decode($out, true);
	        $resultSetArray = $cats['data'];
	        $cacheSvc->save($resultSetArray,$cache_id);
        }
        return $resultSetArray;
    }
    
    /*
     * Collect all packages from repository
     * this can be called from "Refresh" button on local package form or package cronjob
     */
    public function discoverPackages()
    {
        $pkgs = $this->findPackages("[status]=1");
        // update or insert package in package DO
        $localPkgDo = BizSystem::GetObject(self::LOCAL_PACKAGE_DO);
        foreach ($pkgs['data'] as $pkg) {
            pkg_log(">>> Package: ".$pkg['package_id'].", ".$pkg['name'].", ".$pkg['version'].", ".$pkg['repository']."\n");
            // insert or update local master package DO
            $this->saveLocalPackgeRecord($pkg);
        }
        return $pkgs['data'];
    }
    
    protected function findPackages($searchRule, $limit=-1)
    {
        /*
        $context = stream_context_create(array(
        'http' => array(
          'method'  => 'POST',
          'header'  => sprintf("Authorization: Basic %s\r\n", base64_encode($username.':'.$password)).
                       "Content-type: application/x-www-form-urlencoded\r\n",
          'content' => http_build_query(array('status' => $message)),
          'timeout' => 5,
        ),
        ));
        $ret = file_get_contents('http://twitter.com/statuses/update.xml', false, $context); 
        */
        
        // collect all packages from repository
        // make web svc call to repository url
        // parse the reply
        $argsJson = json_encode(array("searchrule"=>"$searchRule","limit"=>$limit));
        $query = array(	"method=search","format=json",
                        "argsJson=$argsJson");
        $httpClient = new HttpClient('POST');
        foreach ($query as $q)
            $httpClient->addQuery($q);
        $headerList = array();
        $out = $httpClient->fetchContents($this->repositoryUrl, $headerList);
        $pkgs = json_decode($out, true);
        return $pkgs;
    }
    
    /*
     * download package. This can be called from "install" button local package view
     */
    public function downloadPackage($package, $install=true)
    {
        $this->_installPackage = $package;
        // get the master package record
        $pkgs = $this->findPackages("[status]=1 AND [name]='$package'");
        if (!$pkgs) { 
            return null;
        }
        //print_r($pkgs);
        
        // download cpk from respository url
        $pkg = $pkgs['data'][0];
 		// this is just for test download bar
 		// $pkg['repository']='http://guides.hosting.czm.cn/test.rar';
        if (empty($pkg)) {
            $this->setInstallInfo($package, array("state"=>"ERROR","log"=>"Unable to find same package from repository"));
            pkg_log("Package download error: Unable to find same package $package from repository");
            return false;
        }
        pkg_log(">>> Package: ".$pkg['package_id'].", ".$pkg['name'].", ".$pkg['version'].", ".$pkg['repository']."\n");
        
        try {
            $this->setInstallInfo($package, array("version"=>$pkg['version'],"state"=>"Start"));
            
            // save cpk to tmp folder           
            $url = $pkg['repository'];
            if (empty($url)) {
                $this->setInstallInfo($package, array("state"=>"ERROR","log"=>"Unable to install from empty url."));
                return false;
            }
            $filename = APP_HOME."/files/tmpFiles/".basename($pkg['repository']);
            pkg_log("Downloading from $url ...\n");
            $this->downloadUrl($url, $filename);
            pkg_log("Completed download from $url ...\n");
            
            if ($install) {
                // install cpk 
                $this->installPackage($filename);
            }
            
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
    
    protected function setInstallInfo($pkgname, $installInfo)
    {
        $pkgDo = BizSystem::GetObject(self::LOCAL_PACKAGE_DO);
        $dataRec = $pkgDo->fetchByName($pkgname);
        if (!$dataRec) return false;

        if (isset($installInfo['version'])) $dataRec["inst_version"] = $installInfo['version'];
        if (isset($installInfo['time'])) $dataRec["inst_time"] = $installInfo['time'];
        if (isset($installInfo['state'])) $dataRec["inst_state"] = $installInfo['state'];
        if (isset($installInfo['log'])) $dataRec["inst_log"] = $installInfo['log'];

        if (isset($installInfo['filesize'])) $dataRec["inst_filesize"] = $installInfo['filesize'];
        if (isset($installInfo['download'])) $dataRec["inst_download"] = $installInfo['download'];
        //BizSystem::log(LOG_DEBUG, "PackageService", "save to db ".print_r($installInfo,1));
        try {
            $dataRec->save();
        }
        catch (Exception $e) {
            throw new Exception("setInstallInfo. Unable to save the record. ".$e->getMessage());
        }
        return true;
    }
    
    protected function getInstallInfo($pkgname)
    {
        $pkgDo = BizSystem::GetObject(self::LOCAL_PACKAGE_DO);
        $record = $pkgDo->fetchByName($pkgname);
        if (!$record) return false;

        return $record["install_info"];
    }
    
    protected function saveLocalPackgeRecord($pkg)
    {
        $pkgDo = BizSystem::GetObject(self::LOCAL_PACKAGE_DO);
        $record = $pkgDo->fetchOne("[package_id]='".$pkg['package_id']."'");
        if (!$record) {
            pkg_log("To insert ".$pkg['name'].", ".$pkg['version']." to local package table\n");
            $dataRec = new DataRecord(null, $pkgDo);
        }
        else {
            //if (strtotime($record['update_time']) >= strtotime($pkg['update_time'])) 
            //    return true;
            pkg_log("To update ".$pkg['name'].", ".$pkg['version']." to local package table\n");
            $dataRec = new DataRecord($record, $pkgDo);
        }
        foreach ($pkg as $fld=>$val) {
            if ($fld!='Id') $dataRec[$fld] = $val;
        }
        try {
            $dataRec->save();
        }
        catch (Exception $e) {
            throw new Exception("saveLocalPackgeRecord. Unable to save the record. ".$e->getMessage());
        }
        return true;
    }

    protected function saveMasterPackgeRecord($pkg)
    {
        $pkgDo = BizSystem::GetObject(self::MASTER_PACKAGE_DO);
        $record = $pkgDo->fetchByName($pkg['name']);
        if (!$record) {
            pkg_log("To insert ".$pkg['name'].", ",$pkg['version']," to local package table\n");
            $dataRec = new DataRecord(null, $pkgDo);
        }
        else {
            if (strtotime($record['update_time']) >= strtotime($pkg['update_time'])) 
                return true;
            pkg_log("To update ".$pkg['name'].", ",$pkg['version']," to local package table\n");
            $dataRec = new DataRecord($record, $pkgDo);
        }
        foreach ($pkg as $fld=>$val) {
            if ($fld!='Id') $dataRec[$fld] = $val;
        }
        try {
            $dataRec->save();
        }
        catch (Exception $e) {
            throw new Exception("saveMasterPackgeRecord. Unable to save the record. ".$e->getMessage());
        }
        return true;
    }
    
    protected function downloadUrl($url, $filename)
    {
    	$package = $this->_installPackage;
        
        //clean setting for counting download, filesize, download size
    	$this->setInstallInfo($package, array("filesize"=>"0" , "download"=>"0"));
    	
    	$filesize = $this->remote_filesize($url);
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
            pkg_log("Downloading ".$utilService->format_bytes($total)." of ".$utilService->format_bytes($filesize)."\n");
            //sleep(2);
        }
        fclose($handle);
        fclose($fp);
    }
    
    protected function remote_filesize($url, $user = "", $pw = "")
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

    /*
        phing unzip package
        upgrader.php to install package
            backup, copy, sql upgrade
            load module
    */
    public function installPackage($cpkFilePath)
    {
        $package = $this->_installPackage;
        $this->setInstallInfo($package, array("state"=>"Install","log"=>"Installing ..."));
        // tmp folder
        $tmpFolder = APP_HOME."/files/tmpfiles";
        $toFolder = $tmpFolder."/".time();
        // unzip cpk file
        try {
            $this->unpack($cpkFilePath, $toFolder);
        }
        catch (Exception $e) {
            throw new Exception("ERROR in unpack $cpkFilePath. ".$e->getMessage());
        }
        pkg_log("Unpack. $cpkFilePath is unpacked to $toFolder\n");
        
        // copy files to target folder from the tmp folder
        $this->filecopy($toFolder);
        
        // invoke module upgrade command
        foreach ($this->_installModules as $moduleName) {
            pkg_log("invoke module upgrade command\n");        
            $loader = new ModuleLoader($moduleName);
            $loader->debug = 0;
            pkg_log("Start upgrading $moduleName module ...".PHP_EOL);
            pkg_log("--------------------------------------------------------".PHP_EOL);
            $result = $loader->upgradeModule();
            pkg_log($loader->errors . "".PHP_EOL);
            pkg_log($loader->logs . "".PHP_EOL);
            if ($result == false) {
                throw new Exception("Error in install package. ".$loader->errors);
            }
            
            // load the module again
            pkg_log(PHP_EOL."Reload module ...".PHP_EOL);
            $loader->loadModule($installSql);
            pkg_log($loader->errors . "".PHP_EOL);
        }
        $time = date('Y-m-d H:i:s');
        $this->setInstallInfo($package, array("time"=>$time,"state"=>"OK","log"=>"Completed"));
    }
    
    protected function filecopy($tmpFolder)
    {
        $dir0s = ob_scandir($tmpFolder);
        // copy module to cubi/upgrade folder
        foreach ($dir0s as $dir0) {
            $dirs = ob_scandir($tmpFolder."/$dir0");
            foreach ($dirs as $dir) {
                $srcDir = $tmpFolder."/$dir0/$dir";
                $dstDir = ($dir == 'modules') ? APP_HOME."/upgrade/modules" : APP_HOME."/$dir";
                pkg_log("copy $srcDir to $dstDir \n");
                recurse_copy($srcDir, $dstDir);
                if ($dir == 'modules')
                    $this->_installModules = ob_scandir($srcDir);
            }
        }
        //print_r($this->_installModules);
    }
    
    protected function unpack($tarfile, $toFolder)
    {
        // include PEAR Tar class
        set_include_path(get_include_path(). PATH_SEPARATOR . APP_HOME."/bin/phing/classes");
        include_once(APP_HOME."/bin/phing/classes/Archive/Tar.php");
        if (!class_exists('Archive_Tar')) {
            throw new Exception("You must have installed the PEAR Archive_Tar class in order to use UntarTask.");
        }
        $tar = $this->initTar($tarfile);
        $result = $tar->extract($toFolder);
        if (!$result) {
            throw new Exception("Could not extract tar file: $tarfile");
        }
    }
    
    /**
     * Init a Archive_Tar class with correct compression for the given file.
     *
     * @param $tarfile
     * @return Archive_Tar the tar class instance
     */
    private function initTar($tarfile)
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
        //pkg_log("tarfilename is $tarfileName, mode is $mode, $compression \n");
        return new Archive_Tar($tarfile, $compression);
    }
}

function pkg_log($text)
{
    if (CLI) echo $text.nl;
    //BizSystem::log(LO_ERR, "ECHO", $text);
    $logfile = LOG_PATH."/install_pkg.log";
    $fp = fopen($logfile, "a+");
    fwrite($fp, date('c')." ".$text);
    fclose($fp);
}
?>