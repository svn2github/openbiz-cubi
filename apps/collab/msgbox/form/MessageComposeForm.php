<?php 
class MessageComposeForm extends EasyForm
{
	public function fetchData()
	{
		if($_GET["F"]!='RPCInvoke'){			
			$dataRec = new DataRecord(null, $this->getDataObj());
	        $dataRec["subject"] = "";
			$dataRec["send_status"] = "draft";
	        $recId = $dataRec->save();
			$this->m_RecordId = $recId;
			$this->m_ActiveRecord = $dataRec;
			$this->setActiveRecord($dataRec->toArray());
		}elseif($this->m_RecordId){
			$this->m_ActiveRecord = $this->getDataObj()
									->fetchById($this->m_RecordId)
									->toArray();
		}		
 		$result = parent::fetchData();
 		
		return $result;
	}
	
	public function LoadDialog($formName,$id=null){
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