<?php
class MessageDraftListForm extends EasyForm
{
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