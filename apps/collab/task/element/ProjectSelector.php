<?php
include_once (OPENBIZ_BIN."/easy/element/DropDownList.php");
class ProjectSelector extends Hidden
{
	public function getSearchRule()
	{
		$value = BizSystem::clientProxy()->getFormInputs($this->m_Name);
		$proj_ids = explode(";", $value);
		
		$searchRule = " ( FALSE ";
		foreach($proj_ids as $id)
		{
			$searchRule .= " OR [".$this->m_FieldName."] = '$id' ";
		}
		$searchRule .= " ) ";
		return $searchRule;        
	}
	
}
?>