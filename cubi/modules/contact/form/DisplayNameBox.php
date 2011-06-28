<?php 
require_once OPENBIZ_BIN.'/easy/element/Listbox.php';
class DisplayNameBox extends Listbox
{
	public function getValue(){
		$value = parent::getValue();
		$firstname 	= BizSystem::clientProxy()->getFormInputs("fld_first_name");
		$lastname 	= BizSystem::clientProxy()->getFormInputs("fld_last_name");
		$company 	= BizSystem::clientProxy()->getFormInputs("fld_company");		
		$value = str_replace("@@Firstname@@",$firstname,$value);
		$value = str_replace("@@Lastname@@", $lastname, $value);
		$value = str_replace("@@Company@@",  $company,  $value);
		return $value;
	}	
}
?>