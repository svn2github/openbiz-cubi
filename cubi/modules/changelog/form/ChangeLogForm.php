<?php 
class ChangeLogForm extends EasyForm
{
	protected  $m_LogDO = "changelog.do.ChangeLogDO";
	protected  $m_ChangeLogMessages;
	protected  $m_ShowComment;
	
	protected function readMetadata(&$xmlArr)
    {
    	$this->m_ShowComment = $xmlArr["EASYFORM"]["ATTRIBUTES"]["SHOWCOMMENT"]?$xmlArr["EASYFORM"]["ATTRIBUTES"]["SHOWCOMMENT"]:'Y';
    	//load message file
    	$this->m_ChangeLogMessages = Resource::loadMessage("changelog.ini" , "changelog");
    	
    	if(strtolower($xmlArr["EASYFORM"]["ATTRIBUTES"]["FORMTYPE"])=='edit' &&
    		$this->m_ShowComment != 'N'
    	){
	    	//add a comment field on fly
	    	$elem_comment_attrs = array(
	    		"NAME"  => 'fld_changelog_comment',
	    		"CLASS"  => 'Textarea',
	    		"ELEMENTSET"  => "Change Comment",
	    		"LABEL" => $this->getChangeLogMessage(CHENGLOG_LABEL),    		
	    		"DESCRIPTION" => $this->getChangeLogMessage(CHENGLOG_DESC),    		
	    	);
	    	$elem_comment = array(
	    		"ATTRIBUTES" => $elem_comment_attrs
	    	);    	
	    	$xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][] = $elem_comment;
    	}
    	parent::readMetaData($xmlArr);
    }
    
    protected function getChangeLogMessage($messageId)
    {
        $message = isset($this->m_ChangeLogMessages[$messageId]) ? $this->m_ChangeLogMessages[$messageId] : constant($messageId);
        $message = I18n::t($message, $messageId, "changelog");
        return @vsprintf($message,$params);
    }    
	
	protected function _doUpdate($inputRecord, $currentRecord)
   	{   		
   		parent::_doUpdate($inputRecord, $currentRecord);
		
   		$postFields = $_POST;
   		$elem_mapping = array();
   		foreach($postFields as $elem_name=>$value)
   		{
   			$elem = $this->m_DataPanel->get($elem_name);
   			$fld_name = $elem->m_FieldName;
   			if($elem){
   				$elem_mapping[$fld_name] = $elem;
   			}
   		}
   		$logDO = $this->getDataObj()->getRefObject($this->m_LogDO);
		if (!$logDO) {
			return true;
		}
				
    	$cond_column = $logDO->m_Association['CondColumn'];
    	$cond_value = $logDO->m_Association['CondValue'];
    	
    	if($cond_column)
    	{
    		$type = $cond_value;
    	}
		$foreign_id = $currentRecord['Id'];
    	
		$logRecord = array();
   		foreach ($inputRecord as $fldName=>$fldVal)
		{
			$oldVal = $currentRecord[$fldName];
			if ($oldVal == $fldVal)
				continue;
			
			$elem = $elem_mapping[$fldName]->m_XMLMeta;		
			if(!$elem){
				$elem = $this->m_DataPanel->getByField($fldName)->m_XMLMeta;
			}	
			$logRecord[$fldName] = array('old'=>$oldVal, 'new'=>$fldVal, 'element'=>$elem);
		}
		
		$comment = BizSystem::clientProxy()->getFormInputs("fld_changelog_comment");		
		
		if (empty($logRecord) && empty($comment))
			return true;
			
		$formMetaLite = array(
			"name" 		=> $this->m_Name,
			"package" 	=> $this->m_Package,
			"message_file" 	=> $this->m_MessageFile,		
		);
		
   		// save to comment do
		$dataRec = new DataRecord(null, $logDO); 
		$dataRec['foreign_id'] = $foreign_id;
		$dataRec['type'] = $type;
		$dataRec['form'] = serialize( $formMetaLite );
		$dataRec['data'] = serialize( $logRecord );
		$dataRec['comment'] = $comment;
		
		
		try {
			$dataRec->save();
		}
        catch (BDOException $e)
        {
            $this->processBDOException($e);
            return true;
        }
        
        $this->runEventLog();
        return true;
	}
}
?>