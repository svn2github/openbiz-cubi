<?php 
class BackupService
{
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    }	
	
    protected function readMetadata(&$xmlArr)
    {
        if(!$this->m_LocationId){
        	$this->getLocationInfo(1);
        }
		$this->m_Folder = APP_FILE_PATH.DIRECTORY_SEPARATOR."backup";		
	}

    public function getLocationInfo($id)
    {    	
    	$locationRec = BizSystem::GetObject("backup.do.BackupDeviceDO")->fetchById($id);
    	if($locationRec){	    	      
	        $this->m_Folder = Expression::evaluateExpression($locationRec['location'],null);            
	        $this->m_Folder = Expression::evaluateExpression($locationRec['location'],null);
    	}	            
    }	
	
	public function BackupDB($name,$timestamp=true)
	{
		$filename = $name;
		$droptable = true;
		if($timestamp)
		{
			$filename.= "-".date("Ymd_His");
		}		
		$dbname="Default";
		
		$result = $this->_dumpDatabase($filename,$dbname,$droptable);
		return $result;	
	}
	
	public function BackupSystem($name,$timestamp=true)
	{
		$filename = $name;
		$droptable = true;
		if($timestamp)
		{
			$filename.= "-".date("Ymd_His");
		}		
		$dbname="Default";
		
		$dbfile = $this->_dumpDatabase($filename, $dbname, 1);        		
        $result = $this->_dumpAllFiles($filename, $dbfile);
        return $result;
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
		
}
?>