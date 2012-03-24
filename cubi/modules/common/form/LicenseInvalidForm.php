<?php 
class LicenseInvalidForm extends EasyForm
{
	public $m_ErrorCode;
	public $m_ErrorParams;
	
	public function outputAttrs()
	{
		$result = parent::outputAttrs();		
		$result['license_message'] = $this->getErrorMessage();
		return $result;
	}
	
	public function getErrorMessage()
	{
		switch((int)$this->m_ErrorCode)
		{
			case 1:
				$msg = "ION_CORRUPT_FILE";
				break;
			case 2:
				$msg = "ION_EXPIRED_FILE";
				break;
			case 3:
				$msg = "ION_NO_PERMISSIONS";
				break;
			case 4:
				$msg = "ION_CLOCK_SKEW";
				break;				
			case 5:
				$msg = "ION_UNTRUSTED_EXTENSION";
				break;
			case 6:
				$msg = "ION_LICENSE_NOT_FOUND";
				break;
			case 7:
				$msg = "ION_LICENSE_CORRUPT";
				break;
			case 8:
				$msg = "ION_LICENSE_EXPIRED";
				break;
			case 9:
				$msg = "ION_LICENSE_PROPERTY_INVALID";
				break;
			case 10:
				$msg = "ION_LICENSE_HEADER_INVALID";
				break;
			case 11:
				$msg = "ION_LICENSE_SERVER_INVALID";
				break;
			case 12:
				$msg = "ION_UNAUTH_INCLUDING_FILE";
				break;
			case 13:
				$msg = "ION_UNAUTH_INCLUDED_FILE";
				break;
			case 14:
				$msg = "ION_UNAUTH_APPEND_PREPEND_FILE";
				break;				
		}
		$msg = $this->getMessage($msg);
		return $msg;
	}
}
?>