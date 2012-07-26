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

$type=BizSystem::ClientProxy()->getRequestParam("type");  
$service=BizSystem::ClientProxy()->getRequestParam("service");

//$whitelist_arr=array('qq','sina','alipay','google','facebook','qzone','twitter');
$whitelist_arr = BizSystem::getService(LOV_SERVICE)->getDictionary("oauth.lov.ProviderLOV(Provider)");

if(!in_array($type,$whitelist_arr)){
	throw new Exception('Unknown service');
	return;
}
 
$oatuthType=MODULE_PATH."/oauth/libs/{$type}.class.php";
if(!file_exists($oatuthType))
{
	throw new Exception('Unknown type');
	return;
}

include_once $oatuthType;
$obj = new $type;
$whitelist_arr=array('CallBack','login');
if(!in_array($service,$whitelist_arr)){
	throw new Exception('Unknown service');
	return;
}

//call_user_method($service, $obj, "\t");
call_user_func(array($obj,$service));
 