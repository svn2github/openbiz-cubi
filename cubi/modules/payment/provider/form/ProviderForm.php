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

class ProviderForm extends EasyForm
{
	public function updateFieldValue($id,$fld_name,$value)
	{
		if($fld_name=='fld_status' && $value==1){
			$rec = $this->getDataObj()->fetchById($id);
			if(!$rec['account'])
			{
				$rec['status'] = $value;
				$rec->save();
				$this->switchForm("payment.provider.form.EditForm",$id);
				return;
			}elseif($recp['require_auth']==1 && (!$rec['username'] || !$rec['password']) ){
				$rec['status'] = $value;
				$rec->save();
				$this->switchForm("payment.provider.form.EditForm",$id);
				return;
			}
		}		
		parent::updateFieldValue($id,$fld_name,$value);
	}
}  
?>