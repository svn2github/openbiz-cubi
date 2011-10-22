<?php
include_once (MODULE_PATH.'/trac/email/TicketEmailService.php');

class TicketForm extends EasyForm 
{ 
   	protected $commentsDOName = "trac.comments.do.CommentsDO";
   	protected $versionDOName = "trac.version.do.VersionDO";
   	protected $milestoneDOName = "trac.milestone.do.MilestoneDO";
   	protected $productDOName = "trac.product.do.ProductDO";
   	protected $componentDOName = "trac.component.do.ComponentDO";
   	protected $userDOName = "system.do.UserDO";
   	
   	protected $ticketEmailSvc = "trac.email.TicketEmailService";
   	
   	protected function _doInsert($inputRecord)
   	{
        $emailSvc = BizSystem::getObject($this->ticketEmailSvc);
        
        parent::_doInsert($inputRecord);
        
        $ticketRec = $this->getActiveRecord($ticket_id);
        
        // send email to ticket owner and cc
        $emailSvc->notifyNewTicket($ticketRec);
        
        return true;
   	}
   
   	protected function _doUpdate($inputRecord, $currentRecord)
   	{
        $emailSvc = BizSystem::getObject($this->ticketEmailSvc);
        
        parent::_doUpdate($inputRecord, $currentRecord);
        
        // get audit dataobj
        $commentsDO = BizSystem::getObject($this->commentsDOName);
        if (!$commentsDO) {
            return;
        }
        $ticket_id = $currentRecord['Id'];
        
        // compose the comments data in serialized array field=>(oldval, newval)
        $data = array();
        
        // reform the record so that the history doesn't include change of field_id
        $this->reformRecord($inputRecord, $currentRecord);
        
        foreach ($inputRecord as $fldName=>$fldVal)
        {
            $oldVal = $currentRecord[$fldName];
            if ($oldVal == $fldVal)
                continue;
            
            $data[$fldName] = array('old'=>$oldVal, 'new'=>$fldVal);
        }
        $comment = BizSystem::clientProxy()->getFormInputs("fld_comments");
        if (!empty($comment))
            $data['comment'] = $comment;
        
        if (empty($data))
            return;
        
        // save to comment do
        $dataRec = new DataRecord(null, $commentsDO); 
        $dataRec['parent_id'] = $ticket_id;
        $dataRec['comments'] = serialize($data);
        try {
            $dataRec->save();
        }
        catch (BDOException $e)
        {
            $this->processBDOException($e);
            return;
        }
        
        $ticketRec = $this->getActiveRecord($ticket_id);
        
        $this->runEventLog();
        
        // send email to ticket owner and cc
        $commentRec['author_id'] = $dataRec['author_id'];
        $commentRec['time'] = $dataRec['time'];
        $commentRec['changes'] = $data;
        $emailSvc->notifyChangeTicket($ticketRec, $commentRec);
        
        return true;
   	}

   	// special logic for version_id, product_id, component_id, milestone_id, owner_id
   	// get the field name value and append it in the array
   	protected function reformRecord(&$inputRecord, $currentRecord)
   	{
        // version_id. 
        if ($inputRecord['version_id']!=$currentRecord['version_id']) {
            $versionDO = BizSystem::getObject($this->versionDOName);
            $version = $versionDO->fetchById($inputRecord['version_id']);
            $inputRecord['version'] = $version['name'];
            unset($inputRecord['version_id']);
        }
        
        // milestone_id
        if ($inputRecord['milestone_id']!=$currentRecord['milestone_id']) {
            $milestoneDO = BizSystem::getObject($this->milestoneDOName);
            $milestone = $milestoneDO->fetchById($inputRecord['milestone_id']);
            $inputRecord['milestone'] = $milestone['name'];
            unset($inputRecord['milestone_id']);
        }
        
        // product_id
        if ($inputRecord['product_id']!=$currentRecord['product_id']) {
            $productDO = BizSystem::getObject($this->productDOName);
            $product = $productDO->fetchById($inputRecord['product_id']);
            $inputRecord['product'] = $product['name'];
            unset($inputRecord['product_id']);
        }
        
        // component_id
        if ($inputRecord['component_id']!=$currentRecord['component_id']) {
            $componentDO = BizSystem::getObject($this->componentDOName);
            $component = $componentDO->fetchById($inputRecord['component_id']);
            $inputRecord['component'] = $component['name'];
            unset($inputRecord['component_id']);
        }
        
        // owner_id
        unset($inputRecord['owner_id']);
    }
}
?>