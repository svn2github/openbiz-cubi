<?php
include_once (OPENBIZ_BIN."/easy/element/DropDownList.php");
class ReadStatusFilter extends DropDownList
{
	public function getSearchRule()
	{
		$value = BizSystem::clientProxy()->getFormInputs($this->m_Name);		
		$my_user_id = BizSystem::getUserProfile("Id");
		switch($value)
		{
			case '0':
				$searchRule = "[Id] not in (select announcement_id from announcement_read_log where user_id='$my_user_id');";
				break;
			case '1':
				$searchRule = "[Id] in (select announcement_id from announcement_read_log where user_id='$my_user_id');";
				break;
			default:
				$searchRule = "";
				break;				
		}
		return $searchRule;		
	}
}
?>