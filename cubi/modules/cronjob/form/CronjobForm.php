<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.cronjob.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

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
