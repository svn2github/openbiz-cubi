<?php 
class ContactForm extends EasyForm
{
	public function insertRecord()
    {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return; 

        //generate fast_index
        $svcobj=BizSystem::getService("service.chineseService");
        if($svcobj->isChinese($recArr['first_name'])){
        	$fast_index = $svcobj->Chinese2Pinyin($recArr['first_name']);
        }else{
        	$fast_index = $recArr['first_name'];
        }
        $recArr['fast_index'] = substr($fast_index,0,1); 
       
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }

        $this->_doInsert($recArr);
        
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();
    }	
    
    public function quickSearch($start=null,$end=null)
    {
    	$start = strtoupper($start);
    	$end = strtoupper($end);
    	$searchRule = "";
    	if($start!='' && $end!=''){
    		$searchRule="'$start'<=[fast_index] AND [fast_index]<='$end'";
    	}
    	elseif($start)
    	{
    		$searchRule="'$start'<[fast_index]";
    	}
    	else
    	{
    		$searchRule="";
    	}
    	
    	$this->setFixSearchRule($searchRule);		
		$this->rerender();
		
    }
    
	public function updateRecord()
	{
		$currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        if($currentRec['user_id']!=0)
        {
        	$user_email = BizSystem::getObject("system.do.UserDO",1)->fetchById($currentRec['user_id'])->email;
        }
        
        if($user_email!=$recArr['email'] 
        	&& $currentRec['user_id']!=0
        	&& $recArr['email']!=''
        	)
        {
        	//check if email address duplicate
        	if ($this->_checkDupEmail($recArr['email'],$currentRec['user_id']))
	        {
	        	$this->setActiveRecord($recArr);
	            $errorMessage = $this->GetMessage("EMAIL_USED");
				$errors['fld_email'] = $errorMessage;
				$this->processFormObjError($errors);
				return;
	        }  
	        
	        	//auto update user's email
	        	$email = $currentRec['email'];
	        	$userRec = BizSystem::getObject("system.do.UserDO",1)->fetchById($currentRec['user_id']);
	        	$userRec['email'] = $recArr['email'];
	        	$userRec->save();
	        
        }
        
		parent::updateRecord();
	}

    protected function _checkDupEmail($email,$ignored_id=0)
    {
        $searchTxt = "[email]='$email'";           
        // query UserDO by the email
        $userDO = BizSystem::getObject("system.do.UserDO",1);
               
        //include optional ID when editing records
        if ($ignored_id > 0 ) {
            $searchTxt .= " AND [Id]!='$ignored_id'";  
        }    
        $records = $userDO->directFetch($searchTxt,1);
        if (count($records)>0)
            return true;
        return false;
    }   	
}
?>
