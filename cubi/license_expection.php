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

function ioncube_event_handler($err_code, $params)
{
	$current_file = $params['current_file'];
	$current_file = str_replace(MODULE_PATH, "", $current_file);
	preg_match("|[\\\/]?(.*?)[\\\/]{1}|si",$current_file,$matches);
	$moduleName = $matches[1];	
	
	BizSystem::instance()->getSessionContext()->setVar("LIC_SOURCE_URL", $_SERVER['REQUEST_URI']);
	BizSystem::instance()->getSessionContext()->setVar("LIC_MODULE", $moduleName);
	
	$lic_file = MODULE_PATH.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'license.key';
	if(is_file($lic_file))
	{
		$formName = "common.form.LicenseInvalidForm";
	}else{
		$formName = "common.form.LicenseInitializeForm";
	}
	
	$formObj = BizSystem::getObject($formName);
	$formObj->m_SourceURL = $_SERVER['REQUEST_URI'];
	$formObj->m_ErrorCode = $err_code;
	$formObj->m_ErrorParams = $params;
	$viewObj = BizSystem::getObject("common.view.LicenseInvalidView");	
	$viewObj->render();	
	exit;
}

