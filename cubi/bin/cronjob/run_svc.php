#!/usr/bin/env php
<?php
/*
 * cron job controller script
 * it reads the cronjob table and runs command based on the command settings 
 */

include_once (dirname(dirname(__FILE__))."/app_init.php");

if ($argc<3) {
	echo "usage: php run_svc.php service_name method parameter1 parameter2 ...\n";
	exit;
}
// read service name and parameters
$svcName = $argv[1];
$methodName = $argv[2];
$arg_list = array();
for($i=3; $i<$argc; $i++) {
	$arg_list[] = $argv[$i];
}

// get service object
$obj = BizSystem::getService($svcName);
if ($obj) {
	if (method_exists($obj, $methodName))
    {
		echo "START - Call $svcName"."."."$methodName(".implode(',',$arg_list).")\n";
    	switch (count($arg_list)) 
        {
        	case 0: $rt_val = $obj->$methodName(); break;
            case 1: $rt_val = $obj->$methodName($arg_list[0]); break;
            case 2: $rt_val = $obj->$methodName($arg_list[0], $arg_list[1]); break;
            case 3: $rt_val = $obj->$methodName($arg_list[0], $arg_list[1], $arg_list[2]); break;
            default: $rt_val = call_user_func_array(array($obj, $methodName), $arg_list);
        }
        if(is_array($rt_val)){
        	echo "DONE - Result is ".print_r($rt_val)." .\n";
        }elseif(is_string($rt_val)){
        	echo "DONE - Result is $rt_val .\n";
        }else{
        	echo "DONE - Result is ".var_dump($rt_val)." .\n";
        }
    }
	else {
		echo "ERROR: Cannot find the method name '$methodName' in the service '$svcName'\n";
		exit;
	}
}
else {
	echo "ERROR: Cannot get the object from service '$svcName'\n";
	exit;
}
?>