#!/usr/bin/env php
<?php
/*
 * Cubi upgrade command line script
 * - first copy the new module source to /cubi/upgrade/modules/mod_name/ folder
 * - then run php /cubi/tool/upgrade.php mod_name
 */

include_once (dirname(dirname(__FILE__))."/app_init.php");

$pkgname = $argv[1];

$packageService = "package.lib.PackageService";
// get package service 
$pkgsvc = BizSystem::GetObject($packageService);
$packages = $pkgsvc->discoverPackages();

$pkgfile = $pkgsvc->downloadPackage($pkgname);

?>