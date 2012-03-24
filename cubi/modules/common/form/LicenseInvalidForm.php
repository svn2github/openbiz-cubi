<?php 
require_once "LicenseForm.php";
class LicenseInvalidForm extends LicenseForm
{
	public $m_LicView;
	
	public function outputAttrs()
	{
		$this->m_LicView = $_SERVER['REQUEST_URI'];
		$this->m_LicView = base64_encode($this->m_LicView);
		$this->getAppModuleName();
		$this->getAppRegister();		
		$result = parent::outputAttrs();		
		$result['license_message'] = $this->getErrorMessage();
		return $result;
	}

}
?>