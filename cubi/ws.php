<?php
/* cubi web service entry point
  request example:
  url
    http://host/cubi/ws.php/email/
  post
    service=EmailService
    method=sendEmail
    api_key=asdkjasdaslkj123123
    *secret=lksadasdklj23213129321lk3
    params[] ->
        toAddress = abc@mail.com
        emailBody = Hello
*/

include_once 'bin/app_init.php';
include_once OPENBIZ_HOME."/bin/ErrorHandler.php";

// find the module name and service name
if(preg_match("/\?\/?(.*?)(\.html)?$/si", $_SERVER['REQUEST_URI'],$match))
{
	//supports for http://localhost/?/user/login format
	//supports for http://localhost/index.php?/user/login format
	$url = $match[1];
}
elseif(strlen($_SERVER['REQUEST_URI'])>strlen($_SERVER['SCRIPT_NAME']))
{
	//supports for http://localhost/index.php/user/login format
    $pos = strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']);
	//$url = str_replace($_SERVER['SCRIPT_NAME'],"",$_SERVER['REQUEST_URI']);
    $url = substr($_SERVER['REQUEST_URI'], $pos+strlen($_SERVER['SCRIPT_NAME']));
	preg_match("/\/?(.*?)(\.html)?$/si", $url,$match);
	$url=$match[1];
}
$inputs = explode("/", $url);
$module = $inputs[0];
$service = isset($inputs[1]) ? $inputs[1] : $_REQUEST['service'];

OB_ErrorHandler::$errorMode = 'text';
$websvc = $module.".websvc.".$service;
// get service object
$svcObj = BizSystem::getObject($websvc);

// invoke the method 
$svcObj->invoke();

?>
