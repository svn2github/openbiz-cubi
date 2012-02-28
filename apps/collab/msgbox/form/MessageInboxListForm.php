<?php
class MessageInboxListForm extends EasyForm
{
	public function DeleteReceivedMessage()
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

	public function ChangeMessageType($form)
    {
    	if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
            
        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        
        if ($selIds == null){    
			if($id)
			{
            	$selIds[] = $id;
			}else{
        		$this->m_Notices[] = $this->getMessage("PLEASE_SELECT_MESSAGE_TO_CHANGE_TYPE");
            	$this->rerender();            
        		return;
			}
        }
        if(is_array($selIds))
        {
        	$this->switchForm($form,$selIds);
        }
    }     
    
	public function fetchDataSet()
	{		
		$resultSet = parent::fetchDataSet();
		$recordSet = array();
		$svc = BizSystem::getService("collab.msgbox.lib.messageService");
		foreach ($resultSet as $record)
		{
			if($record['subject']=="")
			{
				$record['subject']="[no subject]";
			}
			$record['recipient'] = $svc->getRecipientList('Recipient',$record['message_id']);
			$record['attachment'] = $svc->getAttachmentStatus($record['message_id']);
			if(date("Y-m-d",strtotime($record['sent_time']))==date("Y-m-d")){
				$record['sent_time_display'] = date("H:i:s",strtotime($record['sent_time']));
			}else{
				$record['sent_time_display'] = date("y/m/d",strtotime($record['sent_time']));	
			}
			
			
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}    
	
	public function replyMessage($formName)
	{
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
        $prefix = $this->getMessage("MESSAGE_PREFIX_REPLY");
        $message_id = $this->getDataObj()->fetchById($id)->message_id;
        $newId = BizSystem::getService("collab.msgbox.lib.messageService")->replyMessage($prefix,$message_id);
        $this->switchForm($formName,$newId);
	}
	
	public function forwardMessage($formName)
	{
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
        $prefix = $this->getMessage("MESSAGE_PREFIX_FORWARD");
        $message_id = $this->getDataObj()->fetchById($id)->message_id;
        $newId = BizSystem::getService("collab.msgbox.lib.messageService")->forwardMessage($prefix,$message_id);
        $this->switchForm($formName,$newId);
	}
}
?>