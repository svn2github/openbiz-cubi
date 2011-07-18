<?php 
class ReportDbForm extends EasyForm
{
	
	private $m_ReportDO = "report.admin.do.ReportDoDO";
	private $m_ReportFieldDO = "report.admin.do.ReportDoFieldDO";
	
	public function insertRecord(){
		$result = parent::insertRecord();
		//$this->reloadAll();
		return $result;
	}
	
	public function reloadAll(){
		$rec = $this->getActiveRecord();		
    	$server 	= $rec['server'];
    	$port 		= $rec['port'];
    	$driver 	= $rec['driver'];
    	$username 	= $rec['username'];
    	$database 	= $rec['db_name'];
    	$password 	= $rec['password'];
    	$db_id		= $rec['Id'];
    	$charset 	= 'UTF8';
    	
    	if(!$driver)
        	return;		
        
        $report_do = BizSystem::GetObject($this->m_ReportDO,1);	
        $report_field_do = BizSystem::GetObject($this->m_ReportFieldDO,1);	
        
	    switch(strtoupper($driver)){
        	case "PDO_MYSQL":
        		$dbconn = @mysql_connect($server.":".$port,$username,$password);
        		$tablelist = @mysql_list_tables($database,$dbconn);  
        		@mysql_select_db($database);
        		
        		while ($row = @mysql_fetch_array($tablelist)){  
        			$table = $row[0];   
        			if(!$this->_checkDupTablename($row[0],$db_id)){			        			
	        			$report_array =array(
	        				"db_id"=>$db_id,
	        				"table"=>$row[0],
	        				"name"=>ucwords($row[0]),
	        				); 	         			
	        			$report_do->insertRecord($report_array);
	        			$report_record = $report_do->getActiveRecord();
	        			$do_id = $report_record["Id"];
        			}else{
        				//read do_id info
        				$rec = $report_do->directFetch("[table]='$table'",1);
        				$do_id = $rec[0]["Id"];
        			}
	        			//load fields under the table
	        			$fieldlist = mysql_query("SHOW COLUMNS FROM ".$table,$dbconn);
	        			while ($row = mysql_fetch_array($fieldlist)){     
		        			if(!$this->_checkDupFieldname($row['Field'],$do_id)){			        			
			        			$report_array =array(
			        				"do_id"=>$do_id,
			        				"column"=>$row['Field'],
			        				"name"=>ucwords($row['Field']),
			        				"type"=>$this->convertDataType($row['Type'],$driver),
			        				); 
			         
			        			$report_field_do->insertRecord($report_array);   
		        			} 			
		        		} 
        			 			
        		}      		
        		break;        	
        }		
		$this->selectRecord($db_id);
	}
	
	public function reloadTables(){
		$rec = $this->getActiveRecord();		
    	$server 	= $rec['server'];
    	$port 		= $rec['port'];
    	$driver 	= $rec['driver'];
    	$username 	= $rec['username'];
    	$database 	= $rec['db_name'];
    	$password 	= $rec['password'];
    	$db_id		= $rec['Id'];
    	$charset 	= 'UTF8';
    	
    	if(!$driver)
        	return;		
        
        $report_do = BizSystem::GetObject($this->m_ReportDO,1);	
        
	    switch(strtoupper($driver)){
        	case "PDO_MYSQL":
        		$dbconn = @mysql_connect($server.":".$port,$username,$password);
        		$tablelist = @mysql_list_tables($database,$dbconn);  
        		
        		while ($row = @mysql_fetch_array($tablelist)){     
        			if(!$this->_checkDupTablename($row[0],$db_id)){			        			
	        			$report_array =array(
	        				"db_id"=>$db_id,
	        				"table"=>$row[0],
	        				"name"=>ucwords($row[0]),
	        				); 
	         
	        			$report_do->insertRecord($report_array);   
        			} 			
        		}      		
        		break;        	
        }		
		$this->selectRecord($db_id);
	}	
	
    protected function _checkDupTablename($tablename,$db_id)
    {        
        // query UserDO by the username
        $dataobj =  BizSystem::GetObject($this->m_ReportDO,1);	
        $records = $dataobj->directFetch("[table]='$tablename' AND [db_id]='$db_id'",1);
        if (count($records)>=1)
            return true;
        return false;
    }	
    
    protected function _checkDupFieldname($fieldname,$do_id)
    {        
        // query UserDO by the username
        $dataobj =  BizSystem::GetObject($this->m_ReportFieldDO,1);	
        $records = $dataobj->directFetch("[column]='$fieldname' AND [do_id]='$do_id'",1);
        if (count($records)>=1)
            return true;
        return false;
    }   
    protected function convertDataType($datatype,$db_driver){
		switch(strtoupper($db_driver)){
			case 'PDO_MYSQL':
				if(strpos($datatype,'(')){
					preg_match("/(.*?)\(/si",$datatype,$match);
					$datatype = $match[1];
				}
	            switch($datatype){
	            	case "date":
	            		$type= "Date";
	            		break;
	            		
	            	case "timestamp":
	            	case "datetime":
	            		$type= "Datetime";
	            		break; 
	            		
	            	case "int":
	            	case "float":
	            	case "bigint":
	            	case "tinyint":
                    case "decimal":
	            		$type= "Number";
	            		break;
	            				
	            	case "text":
	            	case "shorttext":
	            	case "longtext":      		             		           		
	            	default:
	            		$type= "Text";
	            		break;
	            }
				
	        	break;
		
		}
		return $type;
	}     
}
?>
