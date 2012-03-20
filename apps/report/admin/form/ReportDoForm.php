<?php 
class ReportDoForm extends EasyForm
{
	private $m_ReportFieldDO = "report.admin.do.ReportDoFieldDO";
	
	public function reloadFields($recId)
	{
		$rec = $this->getActiveRecord($recId);
    	$server 	= $rec['server'];
    	$port 		= $rec['port'];
    	$driver 	= $rec['driver'];
    	$username 	= $rec['username'];
    	$database 	= $rec['database'];
    	$password 	= $rec['password'];
    	$table		= $rec['table'];
    	$do_id		= $rec['Id'];
    	$charset 	= 'UTF8';
    	
    	if(!$driver)
        	return;		
        
        $report_fld_do = BizSystem::GetObject($this->m_ReportFieldDO,1);	
        
	    switch(strtoupper($driver)){
        	case "PDO_MYSQL":
        		$dbconn = mysql_connect($server.":".$port,$username,$password);
        		mysql_select_db($database);
        		$fieldlist = mysql_query("SHOW COLUMNS FROM ".$table,$dbconn);  
        		$error = mysql_error();
        		while ($row = mysql_fetch_array($fieldlist)){     
        			if(!$this->_checkDupFieldname($row['Field'],$do_id)){			        			
	        			$report_array =array(
	        				"do_id"=>$do_id,
	        				"column"=>$row['Field'],
	        				"name"=>ucwords($row['Field']),
	        				"type"=>$this->convertDataType($row['Type'],$driver),
	        				); 	         
	        			$report_fld_do->insertRecord($report_array);   
        			} 			
        		}      		
        		break;        	
        }		
		$this->rerenderSubForms();		
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
