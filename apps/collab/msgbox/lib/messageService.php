<?php 
class messageService
{
	public $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	public $m_ContactDO = "contact.do.ContactPickerDO";
	public $m_MessageDO = "collab.msgbox.do.MessageDO";
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
	
	public function getReadStatus($message_id)
	{
		$my_user_id = BizSystem::getUserProfile("Id");
		$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
		$recipients = $recipientDo->directFetch("[message_id]='$message_id' and [user_id]='$my_user_id'");				
		return $recipients[0]['read_status'];		
	}
	
	public function updateReadStatus($message_id)
	{
		if(strtolower($this->getReadStatus($message_id))=='unread')
		{
			$my_user_id = BizSystem::getUserProfile("Id");
			$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
			$recipients = $recipientDo->updateRecords("[read_status]='Read'","[message_id]='$message_id' and [user_id]='$my_user_id'");
		}
	}
	
	public function getAttachmentStatus($message_id){
		$attachmentDo = BizSystem::getObject($this->m_AttachmentDO,1);
		$atts = $attachmentDo->directFetch("[type]='message' AND [foreign_id]='$message_id' ");
		return (int)$atts->count();
	}
	
	public function replyMessage($prefix,$message_id)
	{
		$messageDo = BizSystem::getObject($this->m_MessageDO,1);
		$messageRec = $messageDo->fetchById($message_id);
		$currentRecordId = $messageRec["Id"];
		$recipientId = $messageRec['create_by'];
		
        $newMessageRec = $messageRec;
        unset($newMessageRec["Id"]);
        unset($newMessageRec["create_by"]);
        unset($newMessageRec["create_time"]);
        unset($newMessageRec["update_by"]);
        unset($newMessageRec["update_time"]);
        $newMessageRec['subject'] = $prefix.$newMessageRec['subject'];
        $newMessageRec['send_status'] = 'draft';
        $newRecordId = $messageDo->insertRecord($newMessageRec);
        		
		//process related recipients
		$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
		$newRecRec = array();
		$newRecRec['message_id']=$newRecordId;
		$newRecRec['user_id']=$recipientId;
		$newRecRec['read_status']='Unread';
		$newRecRec['type_id']='1';
		$newRecRec['type']='Recipient';
		$recipientDo->insertRecord($newRecRec);
		
		return $newRecordId;
	}
	
	public function forwardMessage($prefix,$message_id)
	{
		$messageDo = BizSystem::getObject($this->m_MessageDO,1);
		$messageRec = $messageDo->fetchById($message_id);
		$currentRecordId = $messageRec["Id"];
		$recipientId = $messageRec['create_by'];
		
        $newMessageRec = $messageRec;
        unset($newMessageRec["Id"]);
        unset($newMessageRec["create_by"]);
        unset($newMessageRec["create_time"]);
        unset($newMessageRec["update_by"]);
        unset($newMessageRec["update_time"]);
        $newMessageRec['subject'] = $prefix.$newMessageRec['subject'];
        $newMessageRec['send_status'] = 'draft';
        $newRecordId = $messageDo->insertRecord($newMessageRec);
        
		//process related attachemnt
		$attachmentDo = BizSystem::getObject($this->m_AttachmentDO,1);
		$attList = $attachmentDo->directFetch("[type]='message' AND [foreign_id]='$currentRecordId'");
		foreach($attList as $attachmentRec){
			$newAttachmentRec = $attachmentRec;
			$newAttachmentRec['foreign_id']=$newRecordId;
			$attachmentDo->insertRecord($newAttachmentRec);
		}
		
		return $newRecordId;
	}	
	
	public function notifyUsers($msgDO)
	{
		$messageId	= $msgDO->getField('Id')->m_Value;
		$sendStatus = $msgDO->getField('send_status')->m_Value;
		$deleteFlag = $msgDO->getField('deleted_flag')->m_Value;
		$subject 	= $msgDO->getField('subject')->m_Value;
		$content	= $msgDO->getField('content')->m_Value;
		
		if($sendStatus =='sent' && $deleteFlag==0){
			$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
			
			$MsgRecipientDO = BizSystem::getObject("collab.msgbox.do.MessageRecipientDO",1);
			$RecList = $MsgRecipientDO->directFetch("[message_id]='$messageId' AND [read_status]='Unread'");
			foreach ($RecList as $RecipientRecord)
			{
				$recipient_user_id = $RecipientRecord['user_id'];
				$data = array(
					"data_record" => $subject,
					"content" => $content,									
					"app_index" => APP_INDEX,
					"app_url" => APP_URL,
					"operator_name" => BizSystem::GetProfileName(BizSystem::getUserProfile("Id")),
					"action_timestamp"=> date("Y-m-d H:i:s"),
					"refer_url" => SITE_URL
				);				
				$emailSvc->NewMessageEmail($recipient_user_id, $data);
			}
			
			
		}
		
		
	}
}
?>