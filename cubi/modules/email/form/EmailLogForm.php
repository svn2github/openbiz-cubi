<?php 
class EmailLogForm extends EasyForm
{
	public function fetchDataSet(){
		$resultRecords = parent::fetchDataSet()->toArray();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);
		for($i=0;$i<count($resultRecords);$i++)
		{
			$account = $emailSvc->m_Accounts->get($resultRecords[$i]['sender']);						
			$resultRecords[$i]['sender'] = "<a href=\"mailto:".$resultRecords[$i]['sender']."\" >".$resultRecords[$i]['sender_name']."</a>";
			$recipentArr = preg_split('/;/',$resultRecords[$i]['recipients']);
			$resultRecords[$i]['recipients'] = "";
			if(count($recipentArr)>2){
				$spliter=";";
			}
			foreach($recipentArr as $recipent){
				preg_match("/(.*?)\<(.*?)\>/si", $recipent, $match);
				if($match[1])
				{
					$resultRecords[$i]['recipients'].="<a href=\"mailto:".$match[2]."\">".$match[1]."</a>".$spliter;
				}
			} 
		}
 		return $resultRecords;
	}

	public function fetchData(){
		$resultRecords = parent::fetchData();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);

		$account = $emailSvc->m_Accounts->get($resultRecords['sender']);						
		$resultRecords['sender'] = "<a href=\"mailto:".$resultRecords['sender']."\" >".$resultRecords['sender_name']."</a> &lt;".$resultRecords['sender']."&gt;";
		$recipentArr = preg_split('/;/',$resultRecords['recipients']);
		$resultRecords['recipients'] = "";
		foreach($recipentArr as $recipent){
			preg_match("/(.*?)\<(.*?)\>/si", $recipent, $match);
			if($match[1])
			{
				$resultRecords['recipients'].="<a href=\"mailto:".$match[2]."\">".$match[1]."</a> &lt;".$match[2]."&gt;;";
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