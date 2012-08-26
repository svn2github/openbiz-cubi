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

$redirectURL=BizSystem::ClientProxy()->getRequestParam("redirect_url");
if($redirectURL)
{
	BizSystem::sessionContext()->setVar("oauth_redirect_url", $redirectURL);
}

$assocURL	=BizSystem::ClientProxy()->getRequestParam("assoc_url");
if($assocURL)
{
	BizSystem::sessionContext()->setVar("oauth_assoc_url", $assocURL);
}

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
switch(strtolower($service))
{
	case "callback":
	case "login":
		break;
	default:
		throw new Exception('Unknown service');
		break;
}

//call_user_method($service, $obj, "\t");
call_user_func(array($obj,$service));
 