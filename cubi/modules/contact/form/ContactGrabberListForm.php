<?php
class ContactGrabberListForm extends EasyForm
{
	public function Reimport($formName)
	{
        $user_id = BizSystem::GetUserProfile("Id");		
		$do = $this->getDataObj()->deleteRecords("[user_id]=$user_id");
		$this->switchForm($formName);		
	}
	
	public function SelectAll()
	{
		$user_id = BizSystem::GetUserProfile("Id");		
		$do = $this->getDataObj()->updateRecords("[selected]='1'","[user_id]=$user_id");
		$this->updateForm();
	}
	
	public function UnSelectAll()
	{
		$user_id = BizSystem::GetUserProfile("Id");		
		$do = $this->getDataObj()->updateRecords("[selected]='0'","[user_id]=$user_id");
		$this->updateForm();
	}
	
	public function SelectRecord($contact_id=null)
	{
		parent::SelectRecord($contact_id);
		
		if(!$contact_id){
			$contact_id = $this->m_RecordId;
		}
		
		$user_id = BizSystem::GetUserProfile("Id");		
		$do = $this->getDataObj();
		$contactRec = $do->fetchById($contact_id);
		switch($contactRec['selected'])
		{
			case '0':
				$selection = 1;
				break;
			case '1':
				$selection = 0;
				break;				
		}
		
		$do->updateRecords("[selected]='$selection'","[Id]='$contact_id' AND [user_id]=$user_id");
		$this->updateForm();	
	}
}
?>