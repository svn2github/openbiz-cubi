<?php 
class UserRolesForm extends EasyForm{
	public function SetDefault($role_id=null){
		if($role_id==null)
		{
			$role_id =  (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
		}
		$user_id = (int)BizSystem::objectFactory()->getObject('system.form.UserDetailForm')->m_RecordId;
		
		$roleDo = BizSystem::getObject("system.do.UserRoleDO",1);
		$roleDo->updateRecords("[default]=0","[user_id]='$user_id'");		
		$roleDo->updateRecords("[default]=1","[user_id]='$user_id' and [role_id]='$role_id'");
		
		$this->m_RecordId = $role_id;
		$this->UpdateForm();
	}
}
?>