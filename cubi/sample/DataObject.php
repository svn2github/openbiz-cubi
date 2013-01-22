<?php 
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   sample
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: sample.php 4932 2012-12-26 15:42:10Z hellojixian@gmail.com $
 */

require_once dirname(dirname(__FILE__)).'/bin/app_init.php';
$objectName = "system.do.UserDO";
$userDO = BizSystem::getDataObject($objectName);		//get the data object instance

$userRecord = $userDO->fetchById(1);					//fetch a user record which id=1
$userEmail = $userRecord['email'];						//get email attribute from fetched user record

$userRecord['last_login'] = date('Y-m-d H:i:s');		//write a user record object's attribute
$userRecord->save();									//save the record 
?>