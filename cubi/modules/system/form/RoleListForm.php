<?php 
class RoleListForm extends  EasyForm
{
	public function SetPermission()
	{		
        $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
		$redirectPage = APP_INDEX."/system/role_detail/".$id;
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	}
	
}
?>