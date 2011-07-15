<?php 
include_once (OPENBIZ_BIN."/easy/element/InputElement.php");
class ColumListbox extends InputElement{
    public $m_BlankOption;
   
    /**
     * Read metadata info from metadata array and store to class variable
     *
     * @param array $xmlArr metadata array
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_BlankOption = isset($xmlArr["ATTRIBUTES"]["BLANKOPTION"]) ? $xmlArr["ATTRIBUTES"]["BLANKOPTION"] : null;        
    }

    /**
     * Render, draw the control according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $fromList = array();
        $this->getFromList($fromList);
        $valueArray = explode(',', $this->m_Value);
        $disabledStr = ($this->getEnabled() == "N") ? "DISABLED=\"true\"" : "";
        $style = $this->getStyle();
        $func = $this->getFunction();

        //$sHTML = "<SELECT NAME=\"" . $this->m_Name . "[]\" ID=\"" . $this->m_Name ."\" $disabledStr $this->m_HTMLAttr $style $func>";
        $sHTML = "<SELECT NAME=\"" . $this->m_Name . "\" ID=\"" . $this->m_Name ."\" $disabledStr $this->m_HTMLAttr $style $func>";

        if ($this->m_BlankOption) // ADD a blank option
        {
            $entry = explode(",",$this->m_BlankOption);
            $text = $entry[0];
            $value = ($entry[1]!= "") ? $entry[1] : null;
            $entryList = array(array("val" => $value, "txt" => $text ));
            $fromList = array_merge($entryList, $fromList);
        }

        foreach ($fromList as $option)
        {
            $test = array_search($option['val'], $valueArray);
            if ($test === false)
            {
                $selectedStr = '';
            }
            else
            {
                $selectedStr = "SELECTED";
            }
            $sHTML .= "<OPTION VALUE=\"" . $option['val'] . "\" $selectedStr>" . $option['txt'] . "</OPTION>";
        }
        $sHTML .= "</SELECT>";
        return $sHTML;
    }

 	public function getFromList(&$list)
    {
    	/*//get DB list from setting
    	$formobj 	= $this->getFormObj();
    	$rec 		= $formobj->getActiveRecord();  
    	if(is_array($rec)){
	    	$db_id 		= $rec['db_id'];  
	    	$table 		= $rec['datatable'];
    	}else{
    		$do_id 		= $_POST['fld_do_id'];
			$dbobj 		= BizSystem::getObject('report.admin.do.ReportDoDO');
	        $dbArr 		= $dbobj->directFetch("[Id]='$do_id'", 1);
	        if(count($dbArr)==1)
	        	$dbArr=$dbArr[0]; 	        	
	        $db_id 		= $dbArr['db_id'];  
	    	$table 		= $dbArr['table'];   		
    	}
		$dbobj 		= BizSystem::getObject('report.admin.do.ReportDbDO');
        $dbArr 		= $dbobj->directFetch("[Id]='$db_id'", 1);
        if(count($dbArr)==1)
        	$dbArr=$dbArr[0];
    	*/
        $dbobj = BizSystem::getObject('report.admin.do.ReportDbDO');
        $dbArr = $dbobj->getActiveRecord();
        $doObj = BizSystem::getObject('report.admin.do.ReportDoDO');
        $doArr = $doObj->getActiveRecord();
        $table = $doArr['table'];
        
    	$server 	= $dbArr['server'];
    	$port 		= $dbArr['port'];
    	$driver 	= $dbArr['driver'];
    	$username 	= $dbArr['username'];
    	$password 	= $dbArr['password'];
    	$database 	= $dbArr['db_name'];
    	$charset 	= 'UTF8';
    	
        if(!$driver)
        	return;
        
        // TODO: use zend_db listTables and describeTable to list tables and columns
        switch(strtoupper($driver)){
        	case "PDO_MYSQL":
        		$dbconn = @mysql_connect($server.":".$port,$username,$password);
        		@mysql_select_db($database);
        		$fieldlist = mysql_query("SHOW COLUMNS FROM ".$table,$dbconn);  
        		$i = 0 ;
        		while ($row = @mysql_fetch_array($fieldlist)){
        			$list[$i] = array('val'=>$row['Field'],'txt'=>$row['Field']." : ".$row['Type']);
        			$i++;
        		}      		
        		break;        	
        }
    }    
}
?>