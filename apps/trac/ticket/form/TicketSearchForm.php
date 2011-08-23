<?php
include_once (MODULE_PATH.'/trac/email/TicketEmailService.php');

class TicketSearchForm extends EasyForm 
{ 
   	protected $ticketListForm = "trac.ticket.form.TicketResultsForm";
   	protected $ticketQueryDO = "trac.ticket.do.TicketQueryDO";
	
	public function searchTicket()
   	{
   		include_once(OPENBIZ_BIN."/easy/SearchHelper.php");
        $searchRule = "";
        foreach ($this->m_DataPanel as $element)
        {
            if (!$element->m_FieldName)
                continue;

            $value = BizSystem::clientProxy()->getFormInputs($element->m_Name);
            if($element->m_FuzzySearch=="Y")
            {
                $value="*$value*";
            }
            if ($value)
            {
                $searchStr = inputValToRule($element->m_FieldName, $value, $this);
                if ($searchRule == "")
                    $searchRule .= $searchStr;
                else
                    $searchRule .= " AND " . $searchStr;
            }
        }
        
        $searchRuleBindValues = QueryStringParam::getBindValues();
        
   		$listFormObj = BizSystem::getObject($this->ticketListForm);
   		$listFormObj->setSearchRule($searchRule, $searchRuleBindValues);
   		$listFormObj->rerender();
   	}

   	public function saveSearch()
   	{
   		// get non-empty input field value pairs
   		$recArr = $this->readInputRecord();
   		foreach ($recArr as $k=>$v) {	// ignore the empty inputs
   			if (empty($v))
   				unset($recArr[$k]);
   		}
   		$saveAs = BizSystem::clientProxy()->getFormInputs("input_saveas");
   		
   		// serialize it
   		$data = serialize($recArr);
   		
   		// save them in the table
   		$queryObj = BizSystem::getObject($this->ticketQueryDO);
   		$records = $queryObj->directFetch("[name]='$saveAs'",1);
   		if (count($records)>0) {
   			$oldRec = $records[0];
   			$dataRec = new DataRecord($oldRec, $queryObj);
   		}
   		else {
   			$dataRec = new DataRecord(null, $queryObj);
   		}
   		$dataRec['name'] = $saveAs;
   		$dataRec['search_rules'] = $data;

        try
        {
            $dataRec->save();
        }
        catch (BDOException $e)
        {
            $this->processBDOException($e);
            return;
        }
   		$message = $this->getMessage("QUERY_IS_SAVED", array($saveAs));
   		BizSystem::clientProxy()->showClientAlert($message);
        return;
   	}
   	
    public function fetchDataSet()
    {
        $this->prepareQuery();
        
        return parent::fetchDataSet();
    }
    
    protected function prepareQuery()
    {
    	if (isset($_GET['qid']))
        {
			// fetch the saved query record
			$queryObj = BizSystem::getObject($this->ticketQueryDO);
			$record = $queryObj->fetchById($_GET['qid']);
			
			$queryData = unserialize($record['search_rules']);
			$this->m_Title .= " [".$record['name']."]";
        	
        	include_once(OPENBIZ_BIN."/easy/SearchHelper.php");
	        $searchRule = "";
	        foreach ($queryData as $fieldName=>$value)
	        {
	            if ($value)
	            {
	                $searchStr = inputValToRule($fieldName, $value, $this);
	                if ($searchRule == "")
	                    $searchRule .= $searchStr;
	                else
	                    $searchRule .= " AND " . $searchStr;
	            }
	        }
	        
	        $this->setFixSearchRule($searchRule,false);
	        $this->m_SearchRuleBindValues = QueryStringParam::getBindValues();
        }
        else if (isset($_GET['q'])) 
        {
        	$profile = BizSystem::getUserProfile();
        	if ($profile) {
        		$userid = $profile['Id'];
        		if ($_GET['q'] == 'my')
        			$this->setFixSearchRule("[owner_id]=$userid");
        		else if ($_GET['q'] == 'me')
        			$this->setFixSearchRule("[reporter_id]=$userid");
        	}
        }
    }
}
?>