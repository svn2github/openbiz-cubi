<?php 
class ChangeLogService
{
	protected  $m_LogDO = "changelog.do.ChangeLogDO";
	
	public function LogDataChanges( $formObj,
									$inputRecord,
									$currentRecord,
									$comment=null,
									$panel=null )
	{
		if(!$panel)
		{
			$panel = clone $formObj->m_DataPanel;
		}		
		$postFields = $_POST;
   		$elem_mapping = array();
   		
   		foreach($postFields as $elem_name=>$value)
   		{
   			$elem = $panel->get($elem_name);
   			$fld_name = $elem->m_FieldName;
   			if($elem){
   				$elem_mapping[$fld_name] = $elem;
   			}
   		}
   		$logDO = $formObj->getDataObj()->getRefObject($this->m_LogDO);
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
				$elem = $panel->getByField($fldName)->m_XMLMeta;
			}	
			$logRecord[$fldName] = array('old'=>$oldVal, 'new'=>$fldVal, 'element'=>$elem);
		}
		
		
		if (empty($logRecord))
			return true;
			
		$formMetaLite = array(
			"name" 		=> $formObj->m_Name,
			"package" 	=> $formObj->m_Package,
			"message_file" 	=> $formObj->m_MessageFile,		
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
        return true;	
	}
}
?>