<?php 
class BackupForm extends EasyForm
{
	protected $m_Folder;
	protected $m_LocationId;
	protected $m_LocationName;
	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);		        
        if(!$this->m_LocationId){
        	$this->getLocationInfo(1);
        }
		$this->m_Folder = APP_FILE_PATH.DIRECTORY_SEPARATOR."backup";
	}
	
	public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar("backup.form.BackupForms", "LocationId", $this->m_LocationId);
        $sessionContext->getObjVar("backup.form.BackupForms", "LocationName", $this->m_LocationName);
        $sessionContext->getObjVar("backup.form.BackupForms", "Folder", $this->m_Folder);
        return parent::getSessionVars($sessionContext);
    }
 
    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar("backup.form.BackupForms", "LocationId", $this->m_LocationId);
        $sessionContext->setObjVar("backup.form.BackupForms", "LocationName", $this->m_LocationName);
        $sessionContext->setObjVar("backup.form.BackupForms", "Folder", $this->m_Folder);
        return parent::setSessionVars($sessionContext);
    }
    
    public function getLocationInfo($id)
    {
    	$locationRec = BizSystem::GetObject("backup.do.BackupDeviceDO")->fetchById($id);
    	if($locationRec){
	    	$this->m_LocationId = $locationRec["Id"];
    		$this->m_LocationName =  $locationRec["name"];            
	        $this->m_Folder = Expression::evaluateExpression($locationRec['location'],null);            
	        $this->m_Folder = Expression::evaluateExpression($locationRec['location'],null);
    	}	            
    }
	
	public function runSearch()
    {
        foreach ($this->m_SearchPanel as $element)
        {
            if (!$element->m_FieldName)
                continue;

            $value = BizSystem::clientProxy()->getFormInputs($element->m_Name);                                    
            $this->getLocationInfo($value);
        }

        $this->m_RefreshData = true;

        $this->m_CurrentPage = 1;

        $this->runEventLog();
        $this->rerender();
    }    
    
	public function fetchData(){		
        if ($this->m_ActiveRecord != null)
            return $this->m_ActiveRecord;		
		
		preg_match("/\[Id\]='(.*?)'/si",$this->m_FixSearchRule,$match);
		$recId = $match[1];
		
		$resultRecords = $this->fetchFullDataSet();    
        foreach($resultRecords as $rec){
        	if($rec["Id"]==$recId){
        		$record = $rec;
        		break;
        	}
        }

        
        $this->m_RecordId = $record['Id'];
        $this->setActiveRecord($record);        
        return $record;    
	}
	
	private function fetchFullDataSet(){
			//if the folder not exists then create it.
		if(!is_dir($this->m_Folder)){
			$this->init_folder();
		}
	
		/*
		 * id - generated from filename
		 * filename
		 * filesize		 
		 * create_time
		 * update_time
		 */
		$resultRecords = array();
		try{
		foreach(glob($this->m_Folder.DIRECTORY_SEPARATOR."*.tar.gz") as $filename){
			$record = array(
			"Id"		=> md5($filename),
			"type"		=> "tarball",
			"file"		=> $filename,
			"filename" 	=> basename($filename),
			"filesize" 	=> $this->format_bytes(filesize($filename)),
			"update_time" => date("Y-m-d H:i:s",filemtime($filename)),
			"timestamp" => filemtime($filename),
			);
			$resultRecords[filemtime($filename)]=$record;
		}		
		foreach(glob($this->m_Folder.DIRECTORY_SEPARATOR."*.sql") as $filename){
			$record = array(
			"Id"		=> md5($filename),
			"type"		=> "sql",
			"file"		=> $filename,
			"filename" 	=> basename($filename),
			"filesize" 	=> $this->format_bytes(filesize($filename)),
			"update_time" => date("Y-m-d H:i:s",filemtime($filename)),
			"timestamp" => filemtime($filename),
			);
			$resultRecords[filemtime($filename)]=$record;			
		}	
		}catch(Exception $e)
		{
			
		}
		krsort($resultRecords);
		return $resultRecords;
	}
	
	public function fetchDataSet(){

		$resultRecords = $this->fetchFullDataSet();
		//paging		
		$result = array_slice($resultRecords,($this->m_CurrentPage-1)*$this->m_Range,$this->m_Range);
		$this->m_TotalRecords = count($resultRecords);
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		return $result;
		
	}	


	
	public function deleteRecord($id=null){
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;

       $resultRecords = $this->fetchFullDataSet();
            
        foreach ($selIds as $id)
        {
            foreach($resultRecords as $rec){
	        	if($rec["Id"]==$id){	        		
	        		@unlink($rec["file"]);
	        		break;
	        	}
	        }                	        	
        }
        
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();        
	}		
	
	public function Download($id=null){
		if(!$id){
			$id = BizSystem::clientProxy()->getFormInputs('_selectedId');

			$selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
			if($id==null){
				$id=$selIds[0];
			}
			if(!$id){
				$id=$this->m_RecordId;
			}
			if(!$id){
				return;
			}
		}
		$resultRecords = $this->fetchDataSet(); 
        foreach($resultRecords as $rec){
	        if($rec["Id"]==$id){
	        	$record = $rec;	        	
	        	break;
	        }
        }        
        
        $filename = $record["file"];        		
		if(is_file($filename)){
			header("Content-Length: ".filesize($filename));
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        	readfile($filename);
		}else{
		}
        return;
	}
	
	public function Backup(){
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

        //create backup file
        $filename = $recArr['filename'];
        $filename = str_replace(" ","_",$filename);
        
        $filename.="_".str_replace(" ","_",$recArr['database']);
        
        if($recArr['timestamp']){
        	$filename.="_".$recArr['timestamp'];
        }
        switch($recArr['mode'])
        {
        	case 'db_only':
        		$result = $this->_dumpDatabase($filename, $recArr['database'],$recArr['drop_table']);
        		break;
        		
        	case 'db_files':
        		$dbfile = $this->_dumpDatabase($filename,$recArr['database'], 1);        		
        		$result = $this->_dumpUserFiles($filename, $dbfile);
        		break;

        	case 'all_files':
        		$dbfile = $this->_dumpDatabase($filename,$recArr['database'], 1);        		
        		$result = $this->_dumpAllFiles($filename, $dbfile);
        		break; 
        }
        
        
        
    
        $this->m_RecordId = md5($result);
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();		
	}
	
	private function _dumpDatabase($filename,$dbname,$droptable)
	{
		$filename.=".sql";
        $filename = $this->m_Folder.DIRECTORY_SEPARATOR.$filename;
        
		$dbconfigList = BizSystem::getConfiguration()->getDatabaseInfo();
        $dbconfig = $dbconfigList[$dbname];
                      
        
        if(strtolower($dbconfig["Driver"])!='pdo_mysql'){
        	return;
        }
        
        include_once dirname(dirname(__FILE__))."/lib/MySQLDump.class.php";
        $backup = new MySQLDump(); 
        
        if($droptable==1){
        	$backup->droptableifexists = true; 
        }else{
        	$backup->droptableifexists = false;
        }
        if($dbconfig["Port"]){
        	$dbHost = $dbconfig["Server"].":".$dbconfig["Port"];
        }else{
        	$dbHost = $dbconfig["Port"];
        }
        $dbc=$backup->connect($dbHost,$dbconfig["User"],$dbconfig["Password"],$dbconfig["DBName"],$dbconfig["Charset"]);
        if(!$dbc){
        	echo $backup->mysql_error;
        }                 
        $backup->dump();  
        $data = $backup->output;
        file_put_contents($filename,$data);		
        return $filename;
	}
	
	private function _dumpUserFiles($filename,$db_backup){
		$filename.=".tar.gz";
        $filename = $this->m_Folder.DIRECTORY_SEPARATOR.$filename;
        $db_tmpfile = APP_HOME.DIRECTORY_SEPARATOR."database.sql";   
        copy($db_backup,$db_tmpfile);
		$cmd = "tar czf $filename -C '".APP_HOME."' --exclude '.svn' --exclude 'files/cache' --exclude 'files/backup' ./files ./database.sql";
		@exec($cmd,$output);
		@unlink($db_tmpfile);
		@unlink($db_backup);
		return $filename;
	}
	
	private function _dumpAllFiles($filename,$db_backup){
		$filename.=".tar.gz";
        $filename = $this->m_Folder.DIRECTORY_SEPARATOR.$filename;
        $db_tmpfile = APP_HOME.DIRECTORY_SEPARATOR."database.sql";        
        copy($db_backup,$db_tmpfile);
		$cmd = "tar czf $filename -C '".APP_HOME."' --exclude '.svn' --exclude './log' --exclude './session' --exclude 'template/cpl' --exclude 'files/cache' --exclude 'files/backup' ./";
		@exec($cmd,$output);
		@unlink($db_tmpfile);
		@unlink($db_backup);
		return $filename;
	}	
	
	public function Upload(){
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);	
		if(!$recArr['filename']){
			$this->m_Errors = array("fld_name"=>$this->getMessage("FILE_TYPE_INCORRECT"));
			$this->updateForm();
			return;
		}
		
      	$filename = $this->m_Folder.DIRECTORY_SEPARATOR.basename($recArr['filename']);
      	if(preg_match("/.sql$/si",$recArr['filename'])){
      		$recArr['mode']='db';
      	}
		if($recArr["import"]==1){
			switch($recArr['mode'])
	        {
	        	case 'db':	  
	        		$this->_RestoreDB($recArr["database"],$filename,$recArr["charset"]);
	        		break;

	        	case 'db_only':
	        		$db_tmpfile = $this->_RestoreDBFile($filename);
	        		$this->_RestoreDB($recArr["database"],$db_tmpfile,$recArr["charset"]);
	        		@unlink($db_tmpfile);
	        		break;
	        		
	        	case 'files_only':
	        		 $this->_RestoreUserFiles($filename);
	        		break; 
	        		
	        	case 'db_files':
	        		$db_tmpfile = $this->_RestoreDBFile($filename);
	        		$this->_RestoreDB($recArr["database"],$db_tmpfile,$recArr["charset"]);
	        		@unlink($db_tmpfile);
	        		$this->_RestoreUserFiles($filename);
	        		break;		
	        }			
		}
		

        $this->m_RecordId = md5($filename);
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();	        
	}
	
	public function Restore($id=null){
		
		if(!$id){
			$id = BizSystem::clientProxy()->getFormInputs('_selectedId');
			if(!$id){
				return;
			}
		}		
		$this->m_RecordId = $id;
		$recArr = $this->readInputRecord();
		
		$this->m_FixSearchRule="[Id]='$id'";
		$recArrFile = $this->fetchData();
		
		if(!$recArr['import']){
			$this->m_Errors = array("fld_import"=>$this->getMessage("PLEASE_CHECK_AGREEMENT"));
			$this->rerender();
			return;
		}
	    switch($recArr['mode'])
        {
        	case 'db':
        		$this->_RestoreDB($recArr["database"],$recArrFile['file'],$recArr["charset"]);
        		break;
        		        	
        	case 'db_only':
        		$db_tmpfile = $this->_RestoreDBFile($recArrFile['file']);
        		$this->_RestoreDB($recArr["database"],$db_tmpfile,$recArr["charset"]);
        		@unlink($db_tmpfile);
        		break;
        		
        	case 'files_only':
        		 $this->_RestoreUserFiles($recArrFile['file']);
        		break; 
        		
        	case 'db_files':
        		$db_tmpfile = $this->_RestoreDBFile($recArrFile['file']);
        		$this->_RestoreDB($recArr["database"],$db_tmpfile,$recArr["charset"]);
        		@unlink($db_tmpfile);
        		$this->_RestoreUserFiles($recArrFile['file']);
        		break;


        }		
		
		$this->m_Notices = array($this->getMessage("RESTORE_SUCCESSFUL"));
		$this->rerender();
		
		
	}
	
	
	
	public function gotoRestore(){
		$this->m_RecordId = BizSystem::clientProxy()->getFormInputs('_selectedId');
		$this->switchForm("backup.form.BackupRestoreForm",$this->m_RecordId);
	}
	
	private function _restoreDB($db,$sqlfile,$charset=null){
		$query = trim(file_get_contents($sqlfile));
		if (empty($query))
        	return true;
        	
		$db = BizSystem::dbConnection($db);
		if($charset){
			$db->exec("SET NAMES '$charset';");
		}

        include_once MODULE_PATH."/system/lib/MySQLDumpParser.php";
	    $queryArr = MySQLDumpParser::parse($query);
        foreach($queryArr as $query){
			try {
		    	$db->exec($query);
		    } catch (Exception $e) {
		        return false;
		   	}
	    }
	    return true;
	}
	
	private function _restoreDBFile($filename)
	{
		if(!is_dir(TEMPFILE_PATH)){
			@mkdir(TEMPFILE_PATH);
			@chmod(TEMPFILE_PATH,0777);
		}
		$db_tmpfile = TEMPFILE_PATH.DIRECTORY_SEPARATOR."database.sql";
		$cmd = "tar xzf $filename -C '".TEMPFILE_PATH."' ./database.sql";
		@exec($cmd,$output);
		if(is_file($db_tmpfile))
		{
			return $db_tmpfile;
		}
	}
	
	private function _RestoreUserFiles($filename)
	{
		$cmd = "tar xzf $filename -C '".APP_HOME."' --exclude './database.sql'";
		@exec($cmd,$output);
	}
	
	
	
	private function format_bytes($size) {
	    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
	    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
	    return round($size, 2).$units[$i];
	}	
	
	private function init_folder(){
		@mkdir($this->m_Folder,0777,true);
		$this->init_htaccess_protect();
		return;
	}
	
	private function init_htaccess_protect(){
		$filename = $this->m_Folder.DIRECTORY_SEPARATOR.".htaccess";
		$data = "Deny from all";
		return file_put_contents($filename,$data);		
	}
}
?>