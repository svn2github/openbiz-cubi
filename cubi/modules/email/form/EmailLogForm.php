<?php 
class EmailLogForm extends EasyForm
{
	public function fetchDataSet(){
		$resultRecords = parent::fetchDataSet()->toArray();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);
		for($i=0;$i<count($resultRecords);$i++)
		{
			$account = $emailSvc->m_Accounts->get($resultRecords[$i]['sender']);						
			$resultRecords[$i]['sender_email'] = $resultRecords[$i]['sender'];
			$resultRecords[$i]['sender'] = $resultRecords[$i]['sender_name'];			
			$recipentArr = preg_split('/;/',$resultRecords[$i]['recipients']);
			$resultRecords[$i]['recipients'] = "";
			if(count($recipentArr)>2){
				$spliter=";";
			}
			
			foreach($recipentArr as $recipent){
				preg_match("/(.*?)\<(.*?)\>/si", $recipent, $match);
				if($match[1])
				{
					$resultRecords[$i]['recipients'].=$match[1].$spliter;
					$resultRecords[$i]['recipients_email'].=$match[2].$spliter;
				}
			} 
		}
		
 		return $resultRecords;
	}

	public function fetchData(){
		$resultRecords = parent::fetchData();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);
		$account = $emailSvc->m_Accounts->get($resultRecords['sender']);						
		
		$resultRecords['sender_email'] = $resultRecords['sender'];
		$resultRecords['sender'] = $resultRecords['sender_name'];
		
		$recipentArr = preg_split('/;/',$resultRecords['recipients']);
		$resultRecords['recipients'] = "";
		if(count($recipentArr)>2){
				$spliter=";";
			}
		foreach($recipentArr as $recipent){
			preg_match("/(.*?)\<(.*?)\>/si", $recipent, $match);
			if($match[1])
			{
				$resultRecords['recipients'].=$match[1].$spliter;
				$resultRecords['recipients_email'].=$match[2].$spliter;
			}
		}
 		return $resultRecords;
	}
	
	public function ExportCSV()
	{
		$excelSvc = BizSystem::getService(EXCEL_SERVICE);	
		$excelSvc->renderCSV($this->m_Name);
		$this->runEventLog();
		return true;
	}

    public function ClearLog()	
	{
       if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".delete"))
            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        try
        {
          $this->getDataObj()->deleteRecords();
        } 
        catch (BDOException $e)
        {
           $this->processBDOException($e);
           return;
        }
       
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}   
		
}
?>