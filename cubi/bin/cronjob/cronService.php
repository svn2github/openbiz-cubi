<?
include_once ("CronParser.php");

class CronService
{
	const cronjobDO = "cronjob.do.CronjobDO";
	const emailService = "service.userEmailService";
	protected $cronjobDo = null;
	
	public $outputLog = false;
	
	public function run()
	{
		// read cronjob record 
		$this->cronjobDo = BizSystem::getObject(self::cronjobDO);
		if (!$this->cronjobDo) {
			print "Cannot get cronjob DO".nl;
			return false;
		}
		$resultRecords = $this->cronjobDo->directFetch('[status]=1');
		
		$cron = new CronParser();
		foreach ($resultRecords as $record)
		{
			$crontabTime = $this->getCrontabTime($record);
			// get last due time of each job
			$cron->calcLastRan($crontabTime);
			$lastDueTime = $cron->getLastRanUnix();
			// echo $cron->getDebug(); // print cron parse debug info
			echo "lastDueTime of ".$record['Id'].", ".$record['name']." is ".date('Y-m-d H:i:s',$lastDueTime).", last exection time is ".date('Y-m-d H:i:s',$record['last_exec']).nl;

			// if last due < now, execute the command
			$command = Expression::evaluateExpression($record['command'],null);
			
			if ($lastDueTime < time() && $record['last_exec'] < $lastDueTime) {
				echo "Execute job '$command'".nl;
				$this->executeJob($record);
			}
			else {
				echo "Skip job '".$command.nl;
				continue;
			}
		}
	}
	
	public function runJob($jobId)
	{
		$this->cronjobDo = BizSystem::getObject(self::cronjobDO);
		if (!$this->cronjobDo) {
			print "Cannot get cronjob DO".nl;
			return false;
		}
		$jobRec = $this->cronjobDo->fetchById($jobId);
		if ($jobRec) {
			echo "Execute job '".$jobRec['command']."'".nl;
			$this->executeJob($jobRec);
		}
	}
	
	protected function executeJob($cronRecord)
	{
		$name = $cronRecord['name'];
		$maxRun = $cronRecord['max_run'];
		$numRun = $this->getRealNumRun($cronRecord);
		$command = $cronRecord['command'];
		$message = "To execute cron job name=$name, maxrun=$maxRun, numrun=$numRun";
		$this->log($cronRecord, $message);
		// check job max_run and num_run
		if ($cronRecord['max_run']<=0 || $cronRecord['max_run']<=$numRun)
		{
			$this->log($cronRecord, "Skip cron job $name due to reaching maxrun");
			return;
		}
		
		// mark job num_run++
		$this->updateNumRun($cronRecord, true);
		
		// execute the command and write log
		$command = Expression::evaluateExpression($command,null);
		$output = array();
		exec($command, $output);
		foreach ($output as $out)
			$outputStr .= $out."\n";
		$this->log($cronRecord, "Exec results of '$command'\n".$outputStr);
		
		// mark job num_run--
		$this->updateNumRun($cronRecord, false);
		
		// send email
		$emails = trim($cronRecord['sendmail']);
		if ($emails != "") {
			$this->log($cronRecord, "Send job output to '$emails'");
			$emailService = BizSystem::getObject(self::emailService);
			$emailService->CronJobEmail($emails,$name,$outputStr);
		}
	}
	
	protected function getCrontabTime($cronRecord)
	{
		$crontabTime = $cronRecord['minute'];
		$crontabTime .= " ".$cronRecord['hour'];
		$crontabTime .= " ".$cronRecord['day'];
		$crontabTime .= " ".$cronRecord['month'];
		$crontabTime .= " ".$cronRecord['weekday'];
		return $crontabTime;
	}
	
	protected function getRealNumRun($cronRecord)
	{
		$num = 0;
		$command = $cronRecord['command'];
		$command = Expression::evaluateExpression($command,null);
		switch(OS){ //we'd better define a marco to detect system od in sysheader.inc or app_init.php
			case "windows":
				break;			
			case "linux":
			default:

				$result = `ps auxwwww | grep '$command' | grep -v grep | wc -l`;
				$result = (int)$result;				
				break;
		}
		return (int)$result;
	}
	
	protected function updateNumRun($cronRecord, $inc=true)
	{
		$jobId = $cronRecord['Id'];
		$db = $this->cronjobDo->getDBConnection();
		//$time_exec = date("Y-m-d H:i:s",time());
		$time_exec = time();
		if ($inc)
			$sql = "UPDATE ".$this->cronjobDo->m_MainTable." SET last_exec=$time_exec, num_run=num_run+1 WHERE id=$jobId";
		else
			$sql = "UPDATE ".$this->cronjobDo->m_MainTable." SET num_run=num_run-1 WHERE id=$jobId";
        try
        {
        	$this->log($cronRecord, "Run $sql");
            $db->query($sql);
        }
        catch (Exception $e)
        {
            $this->log($cronRecord, "Query error : ".$e->getMessage());
            return false;
        }
        return true;
	}
	
	protected function log($cronRecord, $message)
	{
		if (empty($message))
			return;
		// log file
		$logFile = LOG_PATH."/cron_".$cronRecord['Id'].".log";
		$curTime = date("m/d/Y H:i:s");
		$fp = fopen($logFile, 'a');
		if (!$fp) 
			return;
		fwrite($fp, $curTime."  ".$message."\n");
		fclose($fp);
		if ($this->outputLog) {
			echo $curTime."  ".$message."\n";
		}
	}
}
?>