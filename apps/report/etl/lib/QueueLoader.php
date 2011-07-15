<?php
class QueueLoader
{  
	public $m_Name;
	
	public $m_DataSource;
	public $m_DataSourceName;
	
	public $m_DataDest;
	public $m_DataDestName;
	public $m_Tasks = array();
	private $_dbConnXMLArr;
	private $_dbConnection = array();
	private $_databaseInfo;
	
	
    function __construct(&$xmlArr,&$dbConnections)
    {
        $this->readMetadata($xmlArr,$dbConnections);
    }

    protected function readMetadata(&$xmlArr,&$dbConnections)
    {
    	$this->m_Name = trim($xmlArr["ATTRIBUTES"]["NAME"]) ;
        $this->m_DataSourceName = $xmlArr["ATTRIBUTES"]["SOURCE"] ;
        $this->m_DataDestName 	= $xmlArr["ATTRIBUTES"]["DESTINATION"] ;
        
        //init tasks
	    if(is_array($xmlArr["TASK"][0]["ATTRIBUTES"])){
			$etlTasks = $xmlArr["TASK"];
		}else{
			$etlTasks =  array($xmlArr["TASK"]);
		}
		foreach($etlTasks as $taskXML){
			$EtlClass = $taskXML["ATTRIBUTES"]["CLASS"]?$taskXML["ATTRIBUTES"]["CLASS"]:"EtlTask";
        	$task = new $EtlClass($taskXML,$this);
        	$this->m_Tasks[$task->m_Name] = $task;        	
		}
		
		//init dbConnections		
    	if(is_array($dbConnections[0]["ATTRIBUTES"])){
			$dbConns = $dbConnections;
		}else{
			$dbConns =  array($dbConnections);
		}
		$this->_dbConnXMLArr = $dbConns;
    }
    
    public function process(){
	    if(defined("CLI")){
			echo "\nStart process queues: ".$this->m_Name.PHP_EOL;						
		}    	
	    if(defined("CLI")){
			echo "  Inital data source connection: ".$this->m_DataSourceName.PHP_EOL;						
		}   		
		$this->m_DataSource = $this->getDBConnection($this->m_DataSourceName);
		
		if(defined("CLI")){
			echo "  Inital data destiation connection: ".$this->m_DataDestName.PHP_EOL;						
		} 
		$this->m_DataDest = $this->getDBConnection($this->m_DataDestName);
		
				
    	foreach ($this->m_Tasks as $taskName=>$task){
    		if(defined("CLI")){
				echo "\nCheck etl task status: ".$this->m_Name.".".$task->m_Name;
			} 
    		if($this->m_Tasks[$taskName]->finished() == false){
	    		if(defined("CLI")){
					echo "  [Running]".PHP_EOL;
				}
    			$this->m_Tasks[$taskName]->process();
    		}else{
	    		if(defined("CLI")){
					echo "   [Done] ".PHP_EOL;
				}
    		}
    	}
    	if(defined("CLI")){
			echo "Finished process queues: ".$this->m_Name." [DONE]".PHP_EOL.PHP_EOL;
		} 
    }
    
    private function getDBConnection($dbName){
        $rDBName = (!$dbName) ? "Default" : $dbName;
        if (isset($this->_dbConnection[$rDBName]))
            return $this->_dbConnection[$rDBName];

        $dbInfo = $this->getDatabaseInfo($rDBName);

        require_once 'Zend/Db.php';

        $params = array (
                'host'     => $dbInfo["Server"],
                'username' => $dbInfo["User"],
                'password' => $dbInfo["Password"],
                'dbname'   => $dbInfo["DBName"],
                'port'     => $dbInfo["Port"],
                'charset'  => $dbInfo["Charset"]
        );
        if ($dbInfo["Options"]) {
        	$options = explode(";",$dbInfo["Options"]);
	        foreach ($options as $opt) {
	        	list($k,$v) = explode("=",$opt);
	        	$params[$k] = $v;
	        }
        }
        foreach ($params as $name=>$val) {
        	if (empty($val)) unset($params[$name]);
        }
        if(strtoupper($dbInfo["Driver"])=="PDO_MYSQL")
        {
        	$pdoParams = array(
    			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
			);
			$params["driver_options"]=$pdoParams;
        }
        $db = Zend_Db::factory($dbInfo["Driver"], $params);

        $db->setFetchMode(PDO::FETCH_NUM);
        
        if(strtoupper($dbInfo["Driver"])=="PDO_MYSQL" &&
                $dbInfo["Charset"]!="")
        {
            $db->query("SET NAMES '".$params['charset']."'");
        }
        
        $db->query("SET group_concat_max_len =10240000");
        $this->_dbConnection[$rDBName] = $db;

        return $db;    	
    	
    }
    
    private function getDatabaseInfo($dbName = null)
    {
        if ($dbName && $this->_databaseInfo[$dbName])
            return $this->_databaseInfo[$dbName];

        $breakFlag = false;
        foreach ($this->_dbConnXMLArr as $db)
        {
            if (array_key_exists('ATTRIBUTES', $this->_dbConnXMLArr))
            {
                $db = $this->_dbConnXMLArr;
                $breakFlag = true;
            }
            $tmp["Name"]     = $db["ATTRIBUTES"]["NAME"];
            $tmp["Driver"]   = $db["ATTRIBUTES"]["DRIVER"];
            $tmp["Server"]   = $db["ATTRIBUTES"]["SERVER"];
            $tmp["DBName"]   = $db["ATTRIBUTES"]["DBNAME"];
            $tmp["User"]     = $db["ATTRIBUTES"]["USER"];
            $tmp["Password"] = $db["ATTRIBUTES"]["PASSWORD"];
            $tmp["Port"]     = isset($db["ATTRIBUTES"]["PORT"]) ? $db["ATTRIBUTES"]["PORT"] : null;
            $tmp["Charset"]  = isset($db["ATTRIBUTES"]["CHARSET"]) ? $db["ATTRIBUTES"]["CHARSET"] : null;
            $tmp["Options"]  = isset($db["ATTRIBUTES"]["OPTIONS"]) ? $db["ATTRIBUTES"]["OPTIONS"] : null;
            $this->_databaseInfo[$tmp["Name"]] = $tmp;
            if ($breakFlag)
                break;
        }

        if ($dbName && $this->_databaseInfo[$dbName])
            return $this->_databaseInfo[$dbName];
        if ($dbName && ! isset($this->_databaseInfo[$dbName]))
        {
            $errMsg = BizSystem::getMessage("DATA_INVALID_DBNAME", array($dbName,$dbName));
            trigger_error($errMsg, E_USER_ERROR);
        }
        if (! $dbName)
            return $this->_databaseInfo;
    }    
}
?>