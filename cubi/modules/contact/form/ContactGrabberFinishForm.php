<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.contact.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class ContactGrabberFinishForm extends EasyForm
{
	
	public $SelectedContacts=0;
	
	public function FetchData(){
		$result = parent::fetchData();
		$user_id = BizSystem::GetUserProfile("Id");
		$rs = $this->getDataObj()->directFetch("[selected]=1 and [user_id]='$user_id'");
		$this->SelectedContacts = $rs->count();
		return $result;
	}
		
	public function Finish()
	{
		$recArr = $this->readInputRecord();       
        if (count($recArr) == 0)
            return;

        $user_id = BizSystem::GetUserProfile("Id");           
        $contactImportDO = BizSystem::GetObject("contact.do.ContactImportDO");
        
	    //process data operation
        $data_operation = $recArr['data_operation'];
        switch($data_operation)
        {
        	case "0":
        		break;
        	case "1":        		
        		$contactImportDO->deleteRecords("[user_id]='$user_id' AND [selected]='1'");
        		break;
        	case "2":
        		$contactImportDO->deleteRecords("[user_id]='$user_id'");
        		break;
        }
        
        if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }

        $this->processPostAction();
	}
}
?>