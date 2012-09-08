<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.system.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: UserPreferenceForm.php 3814 2012-08-05 07:27:06Z rockyswen@gmail.com $
 */

/**
 * UserPreferenceForm class - implement the logic of setting user preferences
 *
 * @access public
 */
class ProviderForm extends EasyForm
{
	public function updateRecord()
	{		
		BizSystem::getService("sms.lib.SmsService")->UpdateProviderCounter();
		return parent::updateRecord(); 	
	}  
	
	public function UpdateMessageCounter()
	{
		BizSystem::getService("sms.lib.SmsService")->UpdateProviderCounter();
	}

	public function updateFieldValue($id,$fld_name,$value)
	{
		if($fld_name=='fld_status' && $value==1){
			$rec = $this->getDataObj()->fetchById($id);
			if(!$rec['username'] || !$rec['password'])
			{
				$rec['status'] = $value;
				$rec->save();
				$this->switchForm("sms.provider.form.EditForm",$id);
				return;
			}
		}
		if($value==1){
			//call drivers active method
			$rec = $this->getDataObj()->fetchById($id);
			$driver = $rec['driver'];
			$driverFile = MODULE_PATH.'/'.str_replace(".", '/', $driver).'.php';
			require_once($driverFile);
			$driverName = explode(".",$driver);			
			$driverName = $driverName[count($driverName)-1];			
			$driverObj = new $driverName;			
			$driverObj->activeService();			
		}
		parent::updateFieldValue($id,$fld_name,$value);
	}
}  
?>