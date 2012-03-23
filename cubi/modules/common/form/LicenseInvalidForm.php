<?php 
class LicenseInvalidForm extends EasyForm
{
	public function outputAttrs()
	{
		$result = parent::outputAttrs();
		$result['license_message'] = "sss";
		return $result;
	}
}
?>