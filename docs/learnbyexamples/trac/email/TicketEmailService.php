<?php

include_once(MODULE_PATH."/service/userEmailService.php");

class TicketEmailService extends userEmailService
{
	public function notifyNewTicket($ticketRec)
	{
		// ticket url
		$ticketRec['url'] = SITE_URL.APP_INDEX.'/ticket/detail/'.$ticketRec['Id'];
		
		//init email info
		$template = $this->m_Tempaltes["NewTicketEmail"]["TEMPLATE"];
		$subject  = $this->m_Tempaltes["NewTicketEmail"]["TITLE"];
		$sender   = $this->m_Tempaltes["NewTicketEmail"]["EMAILACCOUNT"];
		$subject = str_replace('{$id}',$ticketRec['Id'],$subject);
		$subject = str_replace('{$summary}',$ticketRec['summary'],$subject);
		
		$template = BizSystem::getTplFileWithPath($template, "trac");
		
		$userObj = BizSystem::getObject("system.do.UserDO");
		// send to owner
        $user_id = $ticketRec['owner_id'];
        $data = $userObj->directFetch("[Id]='".$user_id."'", 1);
        if(count($data)) {
 	        $userData = $data[0];
	        $data = array("ticket"=>$ticketRec, "trac_role"=>'owner');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $userData['email'];
			$recipient['name']  = $userData['username'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
        //email to reporter
		$user_id = $ticketRec['reporter_id'];
        $data = $userObj->directFetch("[Id]='".$user_id."'", 1);
        if(count($data)) {
 	        $userData = $data[0];
	        $data = array("ticket"=>$ticketRec, "trac_role"=>'reporter');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $userData['email'];
			$recipient['name']  = $userData['username'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
        // email to cc
		if(!empty($ticketRec['cc'])) {
	        $data = array("ticket"=>$ticketRec, "trac_role"=>'watcher');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $ticketRec['cc'];
			$recipient['name']  = $recipient['email'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
	}
	
	public function notifyChangeTicket($ticketRec, $commentRec)
	{
		// ticket url
		$ticketRec['url'] = SITE_URL.APP_INDEX.'/ticket/detail/'.$ticketRec['Id'];
		
		//init email info
		$template = $this->m_Tempaltes["ChangeTicketEmail"]["TEMPLATE"];
		$subject  = $this->m_Tempaltes["ChangeTicketEmail"]["TITLE"];
		$sender   = $this->m_Tempaltes["ChangeTicketEmail"]["EMAILACCOUNT"];
		$subject = str_replace('{$id}',$ticketRec['Id'],$subject);
		$subject = str_replace('{$summary}',$ticketRec['summary'],$subject);
		
		$template = BizSystem::getTplFileWithPath($template, "trac");
		
		$userObj = BizSystem::getObject("system.do.UserDO");
		
		// get comment author record
		$user_id = $commentRec['author_id'];
        $data = $userObj->directFetch("[Id]='".$user_id."'", 1);
		if(count($data)) {
			$commentRec['author'] = $data[0]['username'];
			$commentRec['author_email'] = $data[0]['email'];
		}
 	    
		// send to owner
        $user_id = $ticketRec['owner_id'];
        $data = $userObj->directFetch("[Id]='".$user_id."'", 1);
        if(count($data)) {
 	        $userData = $data[0];
	        $data = array("ticket"=>$ticketRec, "comment"=>$commentRec, "trac_role"=>'owner');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $userData['email'];
			$recipient['name']  = $userData['username'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
        //email to reporter
		$user_id = $ticketRec['reporter_id'];
        $data = $userObj->directFetch("[Id]='".$user_id."'", 1);
        if(count($data)) {
 	        $userData = $data[0];
	        $data = array("ticket"=>$ticketRec, "comment"=>$commentRec, "trac_role"=>'reporter');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $userData['email'];
			$recipient['name']  = $userData['username'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
        // email to cc
		if(!empty($ticketRec['cc'])) {
	        $data = array("ticket"=>$ticketRec, "comment"=>$commentRec, "trac_role"=>'watcher');
	               
			//render the email tempalte
			$content = $this->renderEmail($data, $template);
			
			//prepare recipient info
			$recipient['email'] = $ticketRec['cc'];
			$recipient['name']  = $recipient['email'];
			
			//send it to the queue
			$result = $this->sendEmail($sender,$recipient,$subject,$content);
        }
        
        // need to sent email to comment author?

	}

}
?>