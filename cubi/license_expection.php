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
	$formObj = BizSystem::getObject("common.form.LicenseInvalidForm");
	$formObj->m_SourceURL = $_SERVER['REQUEST_URI'];
	$formObj->m_ErrorCode = $err_code;
	$formObj->m_ErrorParams = $params;
	$viewObj = BizSystem::getObject("common.view.LicenseInvalidView");	
	$viewObj->render();	
	exit;
}
?>
