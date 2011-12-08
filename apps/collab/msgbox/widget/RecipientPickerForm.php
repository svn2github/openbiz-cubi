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
    	$parentDo = $parentForm->getDataObj();
    	$parentDo->clearSearchRule();
    	$parentRec = $parentDo->fetchById($parentForm->m_RecordId);
    	$parentRec = $parentRec->toArray();
    	
    	$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
    	//clear associated recipients before save new 
    	foreach($recIdArr as $recId)
    	{
	        $this->m_SearchRule="";
	        $parentForm->getDataObj()->clearSearchRule();
	        
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