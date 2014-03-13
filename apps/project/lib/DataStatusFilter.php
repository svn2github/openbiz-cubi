<?php
include_once (OPENBIZ_BIN."/easy/element/DropDownList.php");
class DataStatusFilter extends DropDownList
{
	public function getSearchRule()
	{
		$value = BizSystem::clientProxy()->getFormInputs($this->m_Name);
		$fieldName = $this->m_FieldName;
		$searchRule = "";		
		switch($value){
			case 'todo':								
				$searchRule = "([$fieldName]= '0' OR [$fieldName]= '1' OR [$fieldName]= '4')";									
				break;
			case '':								
				$searchRule = "";							
				break;
			default:
				$searchRule = "[$fieldName] = '$value'";
				break;
			
		}

		return $searchRule;        
	}
	

}
?>