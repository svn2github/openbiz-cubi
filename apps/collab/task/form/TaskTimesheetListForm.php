<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class TaskTimesheetListForm extends ChangeLogForm
{
	protected $m_GroupBy;
	
	protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
    	$this->m_GroupBy = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["GROUPBY"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["GROUPBY"] : null;    
    }
	
    public function fetchDataGroup()
    {
    	//get group list first
    	$dataObj = $this->getDataObj();    	    	

    	if (!$dataObj) return null;
        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();
        
        if(strpos($this->m_GroupBy,":")){
        	preg_match("/\[(.*?):(.*?)\]/si",$this->m_GroupBy,$match);        	
        	$GroupFieldName = $match[1];
        	$GroupField = $match[2];
	        
        }else{	        
	        $GroupField = str_replace("[","",$this->m_GroupBy);
	        $GroupField = str_replace("]","",$GroupField);        	
        }
        $GroupSQLRule="GROUP BY [$GroupField]";
        
        $sel_date_timestamp= BizSystem::getObject("collab.task.form.TaskTimesheetForm")->m_RecordId;
        $sel_date= date("Y-m-d",$sel_date_timestamp);
        $ExtraSearchRule = "( [start_time]<='$sel_date 23:59:59' AND [finish_time]>'$sel_date 00:00:00' ) ";
        if($this->m_FixSearchRule)
        {
        	$this->m_FixSearchRule = $this->m_FixSearchRule.' AND '.$ExtraSearchRule;
        }else{
        	$this->m_FixSearchRule = $ExtraSearchRule;
        }
        $dataObj->setOtherSQLRule($GroupSQLRule);
        
    	//within each group, search records like before
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);       

        if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
            $searchRule = $this->m_SearchRule;

        $dataObj->setSearchRule($searchRule);
        
        $resultRecords = $dataObj->fetch();
        $this->m_TotalRecords = $dataObj->count();
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
        QueryStringParam::ReSet();
        //looping
        $i=0;
        $results = array();        
        foreach($resultRecords as $record){
        	if ($this->m_RefreshData)
	            $dataObj->resetRules();
	        else
	            $dataObj->clearSearchRule();
        	QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        	$group_val = $record[$GroupField];
	        if ($this->m_FixSearchRule)
	        {
	            if ($this->m_SearchRule)
	                $searchRule = $this->m_SearchRule . " AND " .$this->m_FixSearchRule;
	            else
	                $searchRule = $this->m_FixSearchRule;
	        }
	        else
	            $searchRule = $this->m_SearchRule;
			if($group_val!==null){
		        if($searchRule!=""){
					$searchRule = $searchRule." AND [$GroupField]='$group_val'";	
				}else{
					$searchRule = " [$GroupField]='$group_val'";	
				}
			}else{
				if($searchRule!=""){
					$searchRule = $searchRule." AND [$GroupField]  is NULL";	
				}else{
					$searchRule = " [$GroupField] is NULL";	
				}				
			}
			
			$dataObj->setOtherSQLRule("");
			$dataObj->setLimit(0,0);
	        $dataObj->setSearchRule($searchRule); 
	        $resultRecords_grouped = $dataObj->fetch();
	        //renderTable
	        $resultRecords_grouped_table = $this->m_DataPanel->renderTable($resultRecords_grouped);
	        
	        if($record[$GroupField]!==null){
	        	if($GroupFieldName){
	        		$results[$record[$GroupFieldName]] = $resultRecords_grouped_table;
	        	}else{
	        		$results[$record[$GroupField]] = $resultRecords_grouped_table;
	        	}
	        }else{
	        	$results["Empty"] = $resultRecords_grouped_table;
	        }
	       
	        
	        $i++; 	
	        QueryStringParam::ReSet();
        }
        
        //added pervious other status tasks
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        $dataPermSQLRule = BizSystem::GetService(DATAPERM_SERVICE)->buildSqlRule('update',true);
        $searchRule =  "( [finish_time]<='$sel_date 00:00:00' ) AND ([status]=4 OR [status]=5) AND $dataPermSQLRule";
        $dataObj->setOtherSQLRule("");
		$dataObj->setLimit(0,0);
		$dataObj->clearSearchRule();
        $dataObj->setSearchRule($searchRule); 
        $resultRecords_grouped = $dataObj->fetch();
        //renderTable
        $resultRecords_grouped_table = $this->m_DataPanel->renderTable($resultRecords_grouped);
        $results['prev'] = $resultRecords_grouped_table;
        QueryStringParam::ReSet();
        
        //set active records
        $selectedIndex = 0;
        $this->getDataObj()->setActiveRecord($resultRecords[$selectedIndex]);

        return $results;
    }	
    public function outputAttrs()
    {
    	$output = parent::outputAttrs(); 
    	$svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	    $dataPermSQLRule = $svcObj->buildSqlRule('update',true);
	    $this->m_FixSearchRule = $dataPermSQLRule;   	
    	$output['dataGroup'] = $this->fetchDataGroup();
    	return $output;	
    
    }    		
}
?>