<?php 
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   \
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once 'bin/app_init.php';
include_once OPENBIZ_HOME."/bin/ErrorHandler.php";

//call back handler logic here 
$svc = BizSystem::getService("service.oauthTaobaoService");
$list = $svc->getProviderData();
var_dump($list);// It is a sample about how to read oauth config data
?>
