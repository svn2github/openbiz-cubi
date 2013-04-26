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


/* cubi rest web service entry point
  request example:
  url
    http://host/cubi/rest.php/system/users?start=10&limit=10
*/

include_once 'bin/app_init.php';
include_once OPENBIZ_HOME."/bin/ErrorHandler.php";

require 'bin/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/:module/:resource+', function ($module,$resource) {
	global $app;
    /*echo "Hit $module"; 
	print_r($resource);
	print_r($app->request()->get());
	return;*/
	// forward to module rest service implementation
	$restServiceName = $module.".websvc."."RestService";
	$restSvc = BizSystem::getObject($restServiceName);
	$restSvc->get($resource, $app->request(), $app->response());
});
$app->run();
?>