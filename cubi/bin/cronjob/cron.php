#!/usr/bin/php
<?php
/*
 * cron job controller script
 * it reads the cronjob table and runs command based on the command settings 
 * #!/usr/bin/env php path is not work with cronjob, so have to replace it to an absulately path
 * like 
 */
if (is_file(dirname(dirname(dirname(__FILE__))) . '/files/install.lock')
        && filesize(dirname(dirname(dirname(__FILE__))) . '/files/install.lock') == 1) {
        	

	include_once (dirname(dirname(__FILE__))."/app_init.php");
	include_once (dirname(__FILE__)."/cronService.php");
	
	$cronSvc = new CronService();
	print date("m/d/Y H:i:s")." START cron processor".PHP_EOL;
	$cronSvc->run();
	print date("m/d/Y H:i:s")." END cron processor".PHP_EOL;

}else{
	echo "Openbiz Cubi not installed yet.";
	exit;
}
?>