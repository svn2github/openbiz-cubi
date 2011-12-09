<?php 
class messageService
{
	public $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	public $m_ContactDO = "contact.do.ContactPickerDO";
	public $m_AttachmentDO = "attachment.do.AttachmentDO";
		
	public function getRecipientList($type,$message_id)
	{
		$contactDo = BizSystem::getObject($this->m_ContactDO,1);
		$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
		$recipients = $recipientDo->directFetch("[message_id]='$message_id' and [type]='$type'");
		$list = "";
		foreach($recipients as $recipientArr){			
			$contacts = $contactDo->directFetch("[user_id]='".$recipientArr["user_id"]."'");			
			$list.=$contacts[0]['display_name'].'; ';			
		}		
		return $list;
	}
	
	public function getAttachmentStatus($message_id){
		$attachmentDo = BizSystem::getObject($this->m_AttachmentDO,1);
		$atts = $attachmentDo->directFetch("[type]='message' AND [foreign_id]='$message_id' ");
		return (int)$atts->count();
	}
}
?>