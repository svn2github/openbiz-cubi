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
        
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
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
			array_push($recordSet,$record);
		}
		unset($svc);
		return $recordSet;
	}    
}
?>