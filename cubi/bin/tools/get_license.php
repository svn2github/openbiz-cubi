#!/usr/bin/env php
<?php
/*
 * Cubi license acquisition
 */

include_once ("../app_init.php");
if(!defined("CLI")){
	exit;
}

$licenseClient = "license.lib.LicenseClient";

// get package service 
$licsvc = BizSystem::GetObject($licenseClient);

$package = "trac";
$userInfo = "rocky@gmail.com";
$serverData = base64_encode(ioncube_server_data());

//$license = $licsvc->getTrialLicense($package, $userInfo, $serverData);

$key = 'CUBI-LICENSE-KEY-1';
$license = $licsvc->getFullLicense($package, $key, $userInfo, $serverData);
print_r($license);

?>