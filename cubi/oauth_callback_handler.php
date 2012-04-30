<?php 
include_once 'bin/app_init.php';
include_once OPENBIZ_HOME."/bin/ErrorHandler.php";

//call back handler logic here 
$svc = BizSystem::getService("service.oauthTaobaoService");
$list = $svc->getProviderData();
var_dump($list);// It is a sample about how to read oauth config data
?>