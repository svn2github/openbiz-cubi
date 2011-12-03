<?php 
class ContactGrabberImportForm extends EasyForm
{
	public $SelectedContacts=0;
	
	public function FetchData(){
		$result = parent::fetchData();
		$user_id = BizSystem::GetUserProfile("Id");
		$rs = $this->getDataObj()->directFetch("[selected]=1 and [user_id]='$user_id'");
		$this->SelectedContacts = $rs->count();
		return $result;
	}
	
	public function Import()
	{
		
		$recArr = $this->readInputRecord();       
        if (count($recArr) == 0)
            return;
		
        $ImportOpt = array();
        
        $user_id = BizSystem::GetUserProfile("Id");
        $permOpt['group_id'] = BizSystem::GetUserProfile("default_group");
        $permOpt['group_perm'] = $recArr['group_perm'];
        $permOpt['other_perm'] = $recArr['other_perm'];
        
        switch($recArr['type_selector'])
        {
        	case '0': //assign a exsits
        		$ImportOpt['contact_type'] = $recArr['contact_type_exist'];
        		break;
        	case '1': //create new type
        		$new_type_name = $recArr['contact_type_new'];
        		if($new_type_name=='')
        		{
        			$element = $this->m_DataPanel->get('fld_type_new');
		        	if($element->m_Label)
		            {
		                $elementName = $element->m_Label;
		            }
		            else
		            {
		                $elementName = $element->m_Text;
		            }
        			$errorMessage = $this->getMessage("FORM_ELEMENT_REQUIRED",array($elementName));
               		$this->m_ValidateErrors[$element->m_Name] = $errorMessage;
               		$this->processFormObjError($this->m_ValidateErrors);
            		return false;
        		}
        		//create a new type with specfied sharing setting
        		$newTypeRec = $permOpt;
        		$newTypeRec['name'] = $new_type_name;
        		$newTypeRec['published'] = 1;
        		$newTypeRec['sortorder'] = 50;
        		$contactTypeDO = BizSystem::GetObject("contact.do.ContactTypeDO");
        		$type_id = $contactTypeDO->insertRecord($newTypeRec);
        		$ImportOpt['contact_type'] = $type_id;
        		break;
        }
		
        //start import contact data
        $contactDO = BizSystem::GetObject("contact.do.ContactDO");
        $contactImportDO = BizSystem::GetObject("contact.do.ContactImportDO");
        $selectedContactRecs = $contactImportDO->directFetch("[selected]='1'");
        foreach ($selectedContactRecs as $contactRec)
        {
        	$newContactRec = $contactRec;
        	$newContactRec['group_id'] 		= $permOpt['group_id'];
        	$newContactRec['group_perm'] 	= $permOpt['group_perm'];
        	$newContactRec['other_perm'] 	= $permOpt['other_perm'];
        	$newContactRec['type_id']	 	= $ImportOpt['contact_type'];
        	$newContactRec['sortorder']	 	= '50';
        	unset($newContactRec['user_id']);
        	if(!$newContactRec['company'])
        	{
        		$newContactRec['company']='N/A';
        	}
        	
        	//check exsits
        	$foreign_key 	= $newContactRec['foreign_key'];
        	$source			= $newContactRec['source'];

        	$recs = $contactDO->directfetch("[foreign_key]='$foreign_key' 
        										AND [source]='$source'
        										AND [create_by]='$user_id'");        	        	
        	
        	if($recs->count()==0)
        	{        		
        		$contactDO->insertRecord($newContactRec);        		
        	}
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