<?php 
class MessageForm extends EasyForm
{
	public $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	public $m_AttachmentDO = "attachment.do.AttachmentDO";
	
	public function fetchDataRaw()
	{
		return parent::fetchData();
	}
	
	public function fetchData()
	{						
		if($_GET["F"]!='RPCInvoke')
		{		
			$dataRec = new DataRecord(null, $this->getDataObj());
	        $dataRec["subject"] = "";
			$dataRec["send_status"] = "draft";
	        $recId = $dataRec->save();
			$this->m_RecordId = $recId;
			$this->m_ActiveRecord = $dataRec;			
			$this->setActiveRecord($dataRec->toArray());							
		}
		else
		{		
			if($_GET['fld:Id'])
			{
				//$this->m_BaseSearchRule = "[Id]='$this->m_RecordId'";	
				$this->m_ActiveRecord = $this->getDataObj()->fetchOne("[Id]='".(int)$_GET['fld:Id']."'")->toArray();
			}elseif($this->m_RecordId)
			{
				$this->m_ActiveRecord = BizSystem::getObject($this->getDataObj()->m_Name,1)->fetchOne("[Id]='$this->m_RecordId'")->toArray();
			}
			else
			{
				//$this->m_BaseSearchRule = "";
			}	
		}
		
 		$result = parent::fetchData();
 		if($result['send_status']=='draft'){
 			$result["type_color"] = 'afe8fb'; 				
 		}else{
 			$result["type_color"] = 'c8c8c8';
 		}
 		$result["send_status_display"] = ucwords($result["send_status"]);
 		$result["recipient_to"] = $this->getRecipientList("Recipient");
		$result["recipient_cc"] = $this->getRecipientList("CC");
		$result["recipient_bcc"] = $this->getRecipientList("BCC");
		if($result['subject']=="")
		{
			if($_GET["F"]=='RPCInvoke')
			{
				$result['subject']="[no subject]";
			}else{
				$result['subject']="";
			}
		}
		return $result;
	}
	
	public function getRecipientList($type)
	{
		return BizSystem::getService("collab.msgbox.lib.messageService")->getRecipientList($type,$this->m_RecordId);
	}

	public function LoadDialog($formName,$id=null){
	
		$currentRec = $this->fetchData();
		$recArr = $this->readInputRecord();
        $currentRec['Id'] = $recArr['Id'];
        
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        $recArr['send_status'] = 'draft';

        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;        
           
		parent::loadDialog($formName,$id);	
	}
	
	public function SendMessage()
	{
		$currentRec = $this->getDataObj()->fetchById($this->m_RecordId);			
		$recArr = $this->readInputRecord();
        
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        $recArr['send_status'] = 'sent';
        //update sent_time        
        BizSystem::getObject($this->m_RecipientDO,1)->updateRecords("[sent_time]='".date('Y-m-d H:i:s')."'","[message_id]='".$currentRec['Id']."'");
        
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;        

        if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }

        
        $this->processPostAction();
	}
	
	public function SaveMessage(){
		$currentRec = $this->getDataObj()->fetchById($this->m_RecordId);			
        $recArr = $this->readInputRecord();

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        $recArr['send_status'] = 'draft';
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;
        $this->m_SearchRule = "";
            
        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }
        
       
        $this->processPostAction();
	}
	
	public function ForwardMessage($formName)
	{
		//copy main record to a new record
		$currentRecord = $this->fetchData();	
		$currentRecordId = $currentRecord['Id'];
		$newRecord = $currentRecord;
		$newRecord['send_status'] = 'draft';
		unset($newRecord['Id']);		
		$newRecordId = $this->getDataObj()->insertRecord($newRecord);
		
		//process related attachemnt
		$attachmentDo = BizSystem::getObject($this->m_AttachmentDO,1);
		$attList = $attachmentDo->directFetch("[type]='message' AND [foreign_id]='$currentRecordId'");
		foreach($attList as $attachmentRec){
			$newAttachmentRec = $attachmentRec;
			$newAttachmentRec['foreign_id']=$newRecordId;
			$attachmentDo->insertRecord($newAttachmentRec);
		}
		
		//process related recipients
		$recipientDO = BizSystem::getObject($this->m_RecipientDO,1);
		$recList = $recipientDO->directFetch("[message_id]='$currentRecordId'");
		foreach($recList as $recRec){
			$newRecRec = array();
			$newRecRec['message_id']=$newRecordId;
			$newRecRec['user_id']=$recRec['user_id'];
			$newRecRec['read_status']='Unread';
			$newRecRec['type_id']='1';
			$newRecRec['type']=$recRec['type'];;
			$recipientDO->insertRecord($newRecRec);
		}
		

		//switch to edit form
		$this->switchForm($formName,$newRecordId);
	}
	
   public function SendMessages($id=null)
    {
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {        	
            $dataRec = $this->getDataObj()->fetchById($id);
            $this->getDataObj()->setActiveRecord($dataRec);
                                                
            // take care of exception
            try
            {
            	$dataRec['send_status'] = 'sent';  
            	BizSystem::getObject($this->m_RecipientDO,1)->updateRecords("[sent_time]='NOW()'","[message_id]='".$dataRec['Id']."'");           	
                $dataRec->Save();
            } catch (BDOException $e)
            {
                $this->processBDOException($e);
                return;
            }
        }
        
        $this->m_Notices[] = $this->getMessage("MESSAGE_HAS_BEEN_SENT");

        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }
    
    public function DeleteSentMessage()
    {
    	if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {        	
            $dataRec = $this->getDataObj()->fetchById($id);
            $this->getDataObj()->setActiveRecord($dataRec);
                                                
            // take care of exception
            try
            {
            	$dataRec['deleted_flag'] = '1';            	
                $dataRec->Save();
            } catch (BDOException $e)
            {
                $this->processBDOException($e);
                return;
            }
        }
        
        $this->m_Notices[] = $this->getMessage("MESSAGE_HAS_BEEN_DELETED");
        
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    } 
    
	public function fetchDataSet()
	{		
		//clean complete empty message drafts
		$this->getDataObj()->deleteRecords("[subject]='' AND [content] is NULL");	
		$resultSet = parent::fetchDataSet();
		$recordSet = array();
		$svc = BizSystem::getService("collab.msgbox.lib.messageService");
		foreach ($resultSet as $record)
		{
			if($record['subject']=="")
			{
				$record['subject']="[no subject]";
			}
			$record['recipient'] = $svc->getRecipientList('Recipient',$record['Id']);
			$record['attachment'] = $svc->getAttachmentStatus($record['Id']);	
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}
}
?>