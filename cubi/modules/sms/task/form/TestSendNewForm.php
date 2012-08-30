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
 * @version   $Id: TestSendNewForm.php 3814 2012-08-30  fsliit@gmail.com $
 */
 
class TestSendNewForm extends EasyForm
{
    public function InsertRecord(){
		$readInput=$this->readInputRecord();
		preg_match('/1\d{10}/',$readInput['mobile'],$mobile);
		if(!$mobile)
		{
			$this->m_Errors = array("test"=>$this->getMessage("MOBILE_ERROR"));
			$this->updateForm();
			return false;
		}
		return parent::InsertRecord();
    }    
}  
?>