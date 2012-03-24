<?php 
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