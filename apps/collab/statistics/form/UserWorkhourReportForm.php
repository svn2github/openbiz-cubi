<?php
require_once MODULE_PATH.'/chart/form/ChartForm.php';
class UserWorkhourReportForm extends ChartForm
{
	public $m_Year;
	public $m_Month;
	
	public function runSearch()
	{	
		$data = $this->readInputRecord();		
		$this->m_Year = $data['year'];
		$this->m_Month = $data['month'];
		return parent::runSearch();	
	}
	
	public function fetchDatasetByColumn()
	{
		if(!$this->m_Year){
			$this->m_Year = date('Y');
		}
		if(!$this->m_Month){
			$this->m_Month = date('m');
		}
		
		
		$this->chartCategory = array();
		$this->chartDataAttrset = array();
		$this->chartDataset = array();
		$this->chartDataDescset = array();
		$this->chartDataIdset = array();
		$this->chartColorset = array();
    	// query recordset first
		$dataObj = $this->getDataObj();

        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);

        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();

		//get data range search rule		
		$start_date = $this->m_Year.'-'.$this->m_Month.'-01 00:00:00';
		$end_date = $this->m_Year.'-'.$this->m_Month.'-'.date('t',strtotime($start_date)).' 00:00:00';		
		$this->m_SearchRule = "([create_time]>'$start_date' AND [create_time]<'$end_date')";
		            
		//echo "search rule is $this->m_SearchRule"; exit;
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
        if($this->m_StartItem>1)
        {
            $dataObj->setLimit($this->m_Range, $this->m_StartItem);
        }
        else
        {
            $dataObj->setLimit($this->m_Range, ($this->m_CurrentPage-1)*$this->m_Range);
        }
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        $resultRecords = $dataObj->fetch();
        $this->m_TotalRecords = $dataObj->count();
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		//$resultRecords = $dataObj->directFetch($searchRule);
		$counter = 0;
        while (true)
        {
            $arr = $resultRecords[$counter];
            if (!$arr) break;
            foreach ($this->m_DataPanel as $element)
            {            	
            	if ($element->fieldName && isset($arr[$element->fieldName]))
            	{	            	            			            		
            		switch($element->m_Class)
            		{
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $arr[$element->fieldName];            				
            				break;
            			case "chart.lib.ChartDataId":
            				$this->chartIdset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartDescription":
            				$this->chartDescset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartCategory":
            				$this->chartCategory[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartData":
            				$this->chartDataset[$element->key][] 	 = $arr[$element->fieldName];
            		    	$this->chartDataAttrset[$element->key] = $element->attrs;
            				break;
            		}
            	}
            }
            $counter++;
        }  
	}
	
    public function getSessionVars($sessionContext)
    {    	
    	$sessionContext->getObjVar($this->m_Name, "Year", $this->m_Year);
        $sessionContext->getObjVar($this->m_Name, "Month", $this->m_Month);
        return parent::getSessionVars($sessionContext);
    }


    public function setSessionVars($sessionContext)
    {
    	$sessionContext->setObjVar($this->m_Name, "Year", $this->m_Year);
        $sessionContext->setObjVar($this->m_Name, "Month", $this->m_Month);
        return parent::setSessionVars($sessionContext);        
    }	
}
?>