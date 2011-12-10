<?php 
class MessageComposeForm extends EasyForm
{
	public $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	
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
			if($this->m_RecordId)
			{
				$this->m_SearchRule = "[Id]='$this->m_RecordId'";	
				$this->m_ActiveRecord = null;														
			}
			else
			{
				$this->m_SearchRule = "";
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
			$result['subject']="[no subject]";
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
		$currentRec = parent::fetchData();
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
}
?>