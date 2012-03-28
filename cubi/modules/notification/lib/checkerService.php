<?php 
class checkerService extends MetaObject
{
	protected $m_CheckerList;
	protected $m_CheckerDO = "notification.do.NotificationCheckerDO";	
	protected $m_NotificationDO = "notification.do.NotificationDO";	
	
	public function __construct(&$xmlArr)
	{
		$this->readMetadata($xmlArr);
	}
	
	public function readMetadata($xmlArr)
	{
		parent::readMetadata($xmlArr);
		$checkers = $xmlArr['PLUGINSERVICE']['CHECKER'];
		$this->_processCheckerList($checkers);
	}
	
	protected function _processCheckerList($checkers)
	{
		if($checkers['ATTRIBUTES'])
		{
			$this->m_CheckerList[] = $checkers["ATTRIBUTES"];
		}
		else{
			foreach($checkers as $checker)
			{
				$this->m_CheckerList[] = $checker["ATTRIBUTES"];
			}	
		}
	}
	

	
	public function checkNotification()
	{
		$checkerDO = BizSystem::getObject($this->m_CheckerDO);
		$checkerRecs = $checkerDO->directfetch();
		$checkerLogList = array();
		foreach($checkerRecs as $checker)
		{
			$checkerLogList[$checker['checker']] = strtotime($checker['last_checktime']);
		}
		foreach($this->m_CheckerList as $checker)
		{
			//test is the checker recently called
			if( $checkerLogList[$checker['NAME']] + (int)$checker['MININTERVAL'] < time() ){
			
				$method_name = $checker['MEHTOD'];
				$obj = BizSystem::getObject($checker['SERVICEOBJ']);
				$notificationList = call_user_func(array($obj,$method_name));
				$this->saveNotificationList($notificationList);				
				
				//update checker log
				$checker_name = $checker['NAME'];
				$time_str = date('Y-m-d H:i:s');
				if(isset($checkerLogList[$checker['NAME']]))
				{
					//update it
					$checkerDO->updateRecords("[last_checktime]='$time_str'","[checker]='$checker_name'");
				}
				else
				{
					//insert it
					$checkerLogArr=array(
						"checker" => $checker_name,
						"last_checktime"=>$time_str
					);
					$checkerDO->insertRecord($checkerLogArr);
				}
			}
		}
	}
	
	public function saveNotificationList($notificationList)
	{
		$notiDO = BizSystem::getObject($this->m_NotificationDO);
		$counter = 0;
		foreach ($notificationList as $notiRec)
		{		
			$notiArr = array(				
				"type"=>$notiRec['type'],
				"subject"=>$notiRec['subject'],
				"message"=>$notiRec['message'],
				"goto_url"=>$notiRec['goto_url'],
				"read_state"=>0,
			);	
			$result = $notiDO->insertRecord($notiArr);
			if($result){
				$counter++;
			}
		}
		return $counter;
	}
}
?>