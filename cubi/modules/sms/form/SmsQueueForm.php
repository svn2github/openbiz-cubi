<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.email.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: SmsQueueForm.php 3358 2012-08-15 fsliit@gmail.com $
 */


class SmsQueueForm extends EasyForm
{
	public function SendAllPendingSms()
	{

		return true;
	}
	
	public function sendSms()
	{

		return true;
	}

	public function deleteAllSms()
	{

		return true;
	}

	
	public function deleteSentSms()
	{
		return true;
	}
	
}
?>