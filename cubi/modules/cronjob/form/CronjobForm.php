<?php 
class CronjobForm extends EasyForm
{
	public function runCron()
	{
		include_once (APP_HOME."/bin/cronjob/cronService.php");

		$cronSvc = new CronService();
		print date("m/d/Y H:i:s")." START cron processor".nl;
		$cronSvc->run();
		print date("m/d/Y H:i:s")." END cron processor".nl;
	}
	
	public function runJob($jobId)
	{
		include_once (APP_HOME."/bin/cronjob/cronService.php");

		$cronSvc = new CronService();
		$cronSvc->outputLog = true;
		print "Run job #$jobId ...<br/>"; 
		print "<textarea readonly style=\"width:100%;height:90%\">";
		$cronSvc->runJob($jobId);
		print "</textarea>";
	}
}
?>
