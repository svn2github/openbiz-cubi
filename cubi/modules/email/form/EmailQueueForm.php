<?php 

class EmailQueueForm extends EasyForm
{
	public function SendAllPendingEmails()
	{
//       if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".sendemail"))
//            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);		
            
		$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
		$emailSvc->sendEmailFromQueue();
		$this->runEventLog();
		$this->rerender();
		return true;
	}
	
	public function sendEmails()
	{
//       if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".sendemail"))
//            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;

        $emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);

        foreach ($selIds as $id)
        {            
            try
            {
            	$emailSvc->sendEmailNow($id);         
            } 
            catch (BDOException $e)
            {
                $this->processBDOException($e);
                return;
            }
        }
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}

	public function deleteAllEmails()
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

	
	public function deleteSentEmails()
	{
       if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".delete"))
            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        try
        {
          $this->getDataObj()->deleteRecords("[status]='sent'");
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
	
	public function fetchDataSet(){
		$resultRecords = parent::fetchDataSet()->toArray();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);
		for($i=0;$i<count($resultRecords);$i++)
		{
						
			$account = $emailSvc->m_Accounts->get($resultRecords[$i]['sender']);						
			$resultRecords[$i]['sender'] = $account->m_FromName;
			$resultRecords[$i]['sender_mail'] = $account->m_FromEmail;
			$resultRecords[$i]['recipient_name'] = $resultRecords[$i]['recipient'];
			$resultRecords[$i]['recipient_email'] = $resultRecords[$i]['recipient'];
		}
 		return $resultRecords;
	}

	public function fetchData(){
		$resultRecords = parent::fetchData();
		$emailSvc = BizSystem::getService(EMAIL_SERVICE);

		$account = $emailSvc->m_Accounts->get($resultRecords['sender']);	
		$resultRecords['sender'] = $account->m_FromName;
		$resultRecords['sender_mail'] = $account->m_FromEmail;
		$resultRecords['recipient_name'] = $resultRecords['recipient'];
		$resultRecords['recipient_email'] = $resultRecords['recipient'];					
		//$resultRecords['sender'] = "<a href=\"mailto:".$account->m_FromEmail."\" >".$account->m_FromName."</a> &lt;".$account->m_FromEmail."&gt;   ";
		//$resultRecords['recipient_name'] = "<a href=\"mailto:".$resultRecords['recipient']."\" >".$resultRecords['recipient_name']."</a> &lt;".$resultRecords['recipient']."&gt;   ";

 		return $resultRecords;
	}	
}
?>