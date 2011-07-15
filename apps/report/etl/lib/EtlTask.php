<?php
class EtlTask
{  
	
	public $m_Name;
	protected $m_Finished;
	protected $m_parentObj;
	
	protected $m_SourceSQL;
	protected $m_SourceTable;
	protected $m_DestTable;
	protected $m_KeepData;
	
	protected $m_SourceArr;
	protected $m_DestArr;
	
	protected $m_Transforms;
	
    function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->m_parentObj = $parentObj;

    }

    protected function readMetadata(&$xmlArr)
    {
    	
    	//var_dump($xmlArr);
    	$this->m_Name = trim($xmlArr["ATTRIBUTES"]["NAME"]) ;
        $this->m_SourceSQL = $xmlArr["ATTRIBUTES"]["SOURCESQL"] ;
        $this->m_SourceTable = $xmlArr["ATTRIBUTES"]["SOURCETABLE"] ;
        $this->m_DestTable = $xmlArr["ATTRIBUTES"]["DESTTABLE"] ;   
        $this->m_KeepData = $xmlArr["ATTRIBUTES"]["KEEPDATA"]? strtoupper($xmlArr["ATTRIBUTES"]["KEEPDATA"]):"N";
        $this->m_Transforms = $xmlArr["TRANSFORM"] ; 
    }    
    
    public function finished(){
    	return $this->m_Finished;
    }
    
    public function process(){
    	try{
    		if(defined("CLI")){
					echo "  Extract data from specified table: ".$this->m_parentObj->m_DataSourceName.".".$this->m_SourceTable.PHP_EOL;
					echo "	";
    		}
	    	$this->extract();
    		if(defined("CLI")){
					echo "[DONE]".PHP_EOL;
			}
			
    		if(defined("CLI")){
					echo "  Transform data : ".PHP_EOL;;
					echo "	";
			}			
	    	$this->transform();
    		if(defined("CLI")){
					echo "[DONE]".PHP_EOL;
			}
			
    		if(defined("CLI")){
					echo "  Load data to specified table: ".$this->m_parentObj->m_DataDestName.".".$this->m_DestTable.PHP_EOL;
					echo "	";
			}
	    	$this->load();
    		if(defined("CLI")){
					echo "[DONE]".PHP_EOL;
			}
    	} catch (Zend_Db_Statement_Exception $e) {
    		echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    		exit;
  		}
    }
    
    public function extract(){
    	if($this->m_SourceSQL){
    		//direct load data by specified SQL
    		$sql = $this->m_SourceSQL;
    	}else{
    		//direct load all fields data from table
    		$sql = "SELECT * FROM `".$this->m_SourceTable."`;";
    	}
    	
    	$db = $this->m_parentObj->m_DataSource;
    	$sth = $db->prepare($sql);
    	
    		$sth->execute();
    	
    	
    	$resultset = $sth->fetchAll(PDO::FETCH_ASSOC);
		$this->m_SourceArr =  $resultset;   	
    }

    public function load(){
    	$db = $this->m_parentObj->m_DataDest;
    	//proces keep data logic
    	if($this->m_KeepData=='N'){
    		$sql = "TRUNCATE `".$this->m_DestTable."`";
    		$db->query($sql);
    	}
    	    	

    	foreach($this->m_DestArr as $row){
    		$sql_col = "";
    		$sql_val = "";
    		foreach($row as $col=>$val){
    			$sql_col .= "".$col.",";
    			$sql_val .= "'".$val."',";
    		}    		
    		//remove the last commas
    		$sql_col = substr($sql_col,0,strlen($sql_col)-1);
    		$sql_val = substr($sql_val,0,strlen($sql_val)-1); 
    	    
	    	$sql = "INSERT INTO `".$this->m_DestTable."` ($sql_col) VALUES ($sql_val) ;";
	    	$db->query($sql);
    		if(defined("CLI")){
				echo ".";
			}
    	}
    }

    public function transform(){
    	$destArr = array();
    	foreach($this->m_SourceArr as $row){
    		//transform each data records
    		$destRow = array();
    		foreach($this->m_Transforms as $trans){
    		//load transform rules
    			$source = $trans["ATTRIBUTES"]["SOURCE"]?$trans["ATTRIBUTES"]["SOURCE"]:$trans["SOURCE"];
    			$dest 	= $trans["ATTRIBUTES"]["DEST"]?$trans["ATTRIBUTES"]["DEST"]:$trans["DEST"];
    			$func	= $trans["ATTRIBUTES"]["FUNCTION"]?$trans["ATTRIBUTES"]["FUNCTION"]:$trans["FUNCTION"];
    			if($dest=='*' && $source=='*'){
    				$destRow = $row;    				
    				break;
    			}else{
    			
	    			if(!$func ){
	    				$destRow[$dest] = $row[$source];
	    			}else{
	    				$func_param_arr = array();
	    				preg_match("/(.*?)\((.*?)\)/si",$func,$match);
	    				$func_name = $match[1];
	    				$func_param = $match[2];
	    				//prepare data source parameters supports for multi columns parameters
	    				$source_arr = explode(",",$source);
	    				foreach($source_arr as $source_col){
	    					 array_push($func_param_arr,$row[$source_col]);
	    				}
	    				//prepare user defined parameters
	    				$func_user_param_arr = explode(",",$func_param);
	    				foreach($func_user_param_arr as $param){
	    					array_push($func_param_arr,$param);
	    				}    				    				
	    				$destRow[$dest] = call_user_func_array($func_name,$func_param_arr);
	    			}
    			}
    		}
    		
    		array_push($destArr,$destRow);
    		if(defined("CLI")){
					echo ".";
			}
    	}
    	$this->m_DestArr = $destArr;
    }    
}
?>