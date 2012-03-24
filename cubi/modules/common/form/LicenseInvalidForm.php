<?php 
require_once "LicenseForm.php";
class LicenseInvalidForm extends LicenseForm
{
	public function outputAttrs()
	{
		$this->getAppModuleName();
		$this->getAppRegister();
		
		$result = parent::outputAttrs();		
		$result['license_message'] = $this->getErrorMessage();
		return $result;
	}

}
?>