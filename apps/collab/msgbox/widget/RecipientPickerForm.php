<?php 
class RecipientPickerForm extends PickerForm
{
	
	public $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	public $m_RecipientType ;
	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_RecipientType = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["RECIPIENTTYPE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["RECIPIENTTYPE"] : 'Recipient';        
    }
	
    public function fetchDataSet(){
    	$result = parent::fetchDataSet();
    	$newResult = array();
    	foreach($result as $record){
    		$record['check_status'] = $this->isCheckedRecipient($record['user_id']);
    		array_push($newResult,$record);
    	}
    	return $newResult;
    }
    
    protected function isCheckedRecipient($userId)
    {
    	$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
    	$messageId 	= $parentForm->m_RecordId;
    	$userId 	= (int)$userId;
    	$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
    	$recList = $recipientDo->directFetch("[message_id]='".$messageId."' 
    											AND [type]='".$this->m_RecipientType."'
    											AND [user_id]='$userId'
    											");
    	return (int)$recList->count();
    }
    
    public function clearParent()
    {
    	$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
    	$parentDo = BizSystem::getObject("collab.msgbox.do.MessageContactPickDO");
    	
    	$parentRec = $parentDo->fetchById($parentForm->m_RecordId);
    	$parentRec = $parentRec->toArray();
    	
    	$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
    	$recipientDo->deleteRecords("[message_id]='".$parentRec["Id"]."' AND [type]='".$this->m_RecipientType."'");
    	$this->close();

        $parentForm->rerender();
		if($parentForm->m_ParentFormName){
			$parentForm->renderParent();
		}
    }
    
	public function addToParent($recIds=null)
	{
		if(!is_array($recIds))
    	{    		
    		$recIdArr = array();
    		$recIdArr[] = $recIds;
    	}else{
    		$recIdArr = $recIds;
    	}
    	
    	$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
    	$parentDo = BizSystem::getObject("collab.msgbox.do.MessageContactPickDO");
    	
    	$parentRec = $parentDo->fetchById($parentForm->m_RecordId);
    	$parentRec = $parentRec->toArray();
    	
    	$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
    	//clear associated recipients before save new 
    	$recipientDo->deleteRecords("[message_id]='".$parentRec["Id"]."' AND [type]='".$this->m_RecipientType."'");
    	foreach($recIdArr as $recId)
    	{
	        $this->m_SearchRule="";
	        	        
	        $do = $this->getDataObj();
	        $baseSearchRule = $do->m_BaseSearchRule;
	        $do->m_BaseSearchRule = "";
	        $do->clearSearchRule();	        	        
	        $rec = $do->fetchById($recId);	
			$do->m_BaseSearchRule = $baseSearchRule;						
			
			$newRec = array(
				"message_id" 	=> $parentRec["Id"],
				"user_id" 		=> $rec["user_id"],
				"read_status"	=> 'Unread',
				"importance"	=> '0',
				"type_id"		=> '1',
				'type'			=> $this->m_RecipientType
			);
						
	        $ok = $recipientDo->insertRecord($newRec);
	        if (!$ok)
	            return $parentForm->processDataObjError($ok);
    	}   
    	        
        $this->close();

        $parentForm->rerender();
		if($parentForm->m_ParentFormName){
			$parentForm->renderParent();
		}
				
	}
}
?>