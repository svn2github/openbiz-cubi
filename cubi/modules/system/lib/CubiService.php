<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.system.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ModuleService.php 4449 2012-10-22 06:21:42Z hellojixian@gmail.com $
 */

class CubiService
{
	const CUBI_VERSION = "3.0";
	
	public function getVersion()
	{
		return self::CUBI_VERSION;
	}
	
	public function collectUserData($sendContact=0)
	{
		//sendContact = 0 ; don't send contact info
		//sendContact = 1 ; send contact info
		
		$uuid = $this->getSystemUUID();
	}
	
	public function getSystemUUID()
	{		
		$dataFile = APP_HOME.'/files/system_uuid.data';
		if(is_file($dataFile))
		{
			$uuid = file_get_contents($dataFile);
			$uuid = trim($uuid);
		}
		else
		{
			$uuid = uniqid();
			file_put_contents($dataFile,$uuid);	
		}
		return $uuid;
	}
}
?>