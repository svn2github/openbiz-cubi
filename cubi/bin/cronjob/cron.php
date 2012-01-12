#!/usr/bin/php
<?php
/*
 * cron job controller script
 * it reads the cronjob table and runs command based on the command settings 
 * #!/usr/bin/env php path is not work with cronjob, so have to replace it to an absulately path
 * like 
 */

include_once (dirname(dirname(__FILE__))."/app_init.php");
include_once ("cronService.php");

$cronSvc = new CronService();
print date("m/d/Y H:i:s")." START cron processor".PHP_EOL;
$cronSvc->run();
print date("m/d/Y H:i:s")." END cron processor".PHP_EOL;
?>