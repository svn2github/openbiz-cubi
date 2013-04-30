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
// GET request
$app->get('/:module/:resource/:id', function ($module,$resource,$id) {
	$app = \Slim\Slim::getInstance();
	// forward to module rest service implementation
	$restServiceName = $module.".websvc."."RestService";
	$restSvc = BizSystem::getObject($restServiceName);
	$restSvc->get($resource, $id, $app->request(), $app->response());
});

// POST request
$app->post('/:module/:resource',  function ($module,$resource) {
	$app = \Slim\Slim::getInstance();
	// forward to module rest service implementation
	$restServiceName = $module.".websvc."."RestService";
	$restSvc = BizSystem::getObject($restServiceName);
	$restSvc->post($resource, $app->request(), $app->response());
});

// PUT request
$app->put('/:module/:resource/:id',  function ($module,$resource,$id) {
	$app = \Slim\Slim::getInstance();
	// forward to module rest service implementation
	$restServiceName = $module.".websvc."."RestService";
	$restSvc = BizSystem::getObject($restServiceName);
	$restSvc->put($resource, $id, $app->request(), $app->response());
});

// DELETE request
$app->delete('/:module/:resource/:id',  function ($module,$resource,$id) {
	$app = \Slim\Slim::getInstance();
	// forward to module rest service implementation
	$restServiceName = $module.".websvc."."RestService";
	$restSvc = BizSystem::getObject($restServiceName);
	$restSvc->delete($resource, $id, $app->request(), $app->response());
});

$app->run();
?>