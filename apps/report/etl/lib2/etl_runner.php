#!/usr/bin/env php
<?php

if(isset($argc)){ 
	if ($argc<3) {
		echo "usage: php etl_runner.php [config_file] [job_name]".PHP_EOL;
		exit;
	}else{
		echo PHP_EOL;
		echo str_repeat("=",52).PHP_EOL;
		echo "\tOpenbiz Reporting ETL Module ".PHP_EOL;
		echo str_repeat("=",52).PHP_EOL;
		echo PHP_EOL;
	}
}
include_once (dirname(dirname(__FILE__))."/app_init.php");
include_once (dirname(__FILE__)."/gen_meta.inc.php");
if(!defined("CLI")){
	exit;
}

$etl_path = APP_HOME.DIRECTORY_SEPARATOR."bin".DIRECTORY_SEPARATOR."etl";

include_once "$etl_path/lib/ETLJob.php";

//assign paramenters
$config_file = $argv[1]?$argv[1]:"etl_sample.xml";
if($argv[2]){
	$job_name = $argv[2];
}else{
	$job_name = "all";
}

//load config data
if(defined("CLI")){
	echo "\nLoading ETL config file $config_file : \n";
} 

$conf_file = $etl_path.DIRECTORY_SEPARATOR.$config_file;

if(!is_file($conf_file)){
	echo "Config file $conf_file not found! ";
	exit;
}
$xmlArr = BizSystem::getXmlArray($conf_file);
if(is_array($xmlArr["ETL"]["JOB"][0]["ATTRIBUTES"])){
	$etlJobsArr = $xmlArr["ETL"]["JOB"];	
}else{
	$etlJobsArr = array($xmlArr["ETL"]["JOB"]);
}
if(is_array($xmlArr["ETL"]["DATASOURCE"]["DATABASE"][0]["ATTRIBUTES"])){
	$dbConnections = $xmlArr["ETL"]["DATASOURCE"]["DATABASE"];	
}else{
	$dbConnections = array($xmlArr["ETL"]["DATASOURCE"]["DATABASE"]);
}
if(defined("CLI")){
	echo "\t".basename($config_file)." \n";
} 

//init for each job
foreach ($etlJobsArr as $jobXMLArr){
	$etlJob = new ETLJob($jobXMLArr,$dbConnections);
	$etlJob->process(); 
}


echo PHP_EOL;
echo str_repeat("=",52).PHP_EOL;
echo "\tETL Process Finished ".PHP_EOL;
echo str_repeat("=",52).PHP_EOL;
echo PHP_EOL;
?>