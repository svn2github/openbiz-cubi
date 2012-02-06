<?php 
class UserGroupsForm extends EasyForm{
	public function SetDefault($group_id=null){
		if($group_id==null){
			$group_id =  (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}
		$user_id = (int)BizSystem::objectFactory()->getObject('system.form.UserDetailForm')->m_RecordId;
		
		$groupDo = BizSystem::getObject("system.do.UserGroupDO",1);
		$groupDo->updateRecords("[default]=0","[user_id]='$user_id'");		
		$groupDo->updateRecords("[default]=1","[user_id]='$user_id' and [group_id]='$group_id'");
		
		$this->m_RecordId = $group_id;
		$this->UpdateForm();
	}
}
?>