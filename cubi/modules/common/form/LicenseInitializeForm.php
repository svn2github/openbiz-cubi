<?php 
require_once "LicenseForm.php";
class LicenseInitializeForm extends LicenseForm
{
	public function GoActive()
	{
		$rec = $this->readInputRecord();
		$this->setActiveRecord($rec);
		if($rec['eula']=="0"){
			$this->m_Errors = array("fld_eula"=>'You must agree with the license');
			$this->m_hasError = true;	
			BizSystem::clientProxy()->setRPCFlag(true);		
			return parent::rerender();
		}
		
		$appInfo = $this->getAppInfo();
		if(!$appInfo){
			$rec['howto_active'] = 'ENTER';
		}
		
		switch(strtoupper($rec['howto_active']))
		{
			case "ENTER":				
				$this->switchForm("common.form.LicenseActiveForm");
				break;
			case "FREETRIAL":
				$this->getTrailLicense();
				break;
			case "PURCHASE":				
				$url = $appInfo['APP_PURCHASE'];
				BizSystem::clientProxy()->redirectPage($url);
				break;
		}
	}
	
	public function getTrailLicense()
	{
		
	}
}
?>