<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

require_once "LicenseForm.php";
class LicenseActiveForm extends LicenseForm
{
	public $m_ActiveModuleName;
	public $m_LastView;
	
 	public function setSessionVars($sessionContext)
    {               
	 	$sessionContext->setObjVar("common.LicenseForm", "ActiveModuleName", $this->m_ActiveModuleName);       
	 	$sessionContext->setObjVar("common.LicenseForm", "LastView", $this->m_LastView);
     	parent::setSessionVars($sessionContext);        
    }	
	
	public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar("common.LicenseForm", "ActiveModuleName", $this->m_ActiveModuleName);
        $sessionContext->getObjVar("common.LicenseForm", "LastView", $this->m_LastView);
     	parent::getSessionVars($sessionContext);        
    }	
	
	public function fetchData()
	{
		$this->m_LastView = base64_decode($_GET['lastview']);
		$this->m_ActiveModuleName = $_GET['app'];
		$this->m_ModuleName = $_GET['app'];
		$result['license_code']=$this->getExistingLicenseCode();
		$this->getAppRegister();		
		return $result;
	}
	
	protected function getRedirectPage()
	{
		
		if($this->m_LastView)
		{
			$view = $this->m_LastView;
			return array($view,"");
		}
	}
	
	public function activeLicense()
	{	
		$rec = $this->readInputRecord();
		$lic_code = $rec['license_code'];
		$this->setLicenseCode($lic_code);
		$this->processPostAction(); 
		return;
	}
	
	public function getExistingLicenseCode()
	{
		$lic_file = MODULE_PATH.DIRECTORY_SEPARATOR.$this->m_ActiveModuleName.DIRECTORY_SEPARATOR.'license.key';
		if(file_exists($lic_file))
		{
			return file_get_contents($lic_file);
		}
	}	
	
	public function setLicenseCode($code)
	{
		$lic_file = MODULE_PATH.DIRECTORY_SEPARATOR.$this->m_ActiveModuleName.DIRECTORY_SEPARATOR.'license.key';	
		return file_put_contents($lic_file,$code);
	}
}
?>