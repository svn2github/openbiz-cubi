<?php 
class checkerService extends MetaObject
{
	protected $m_CheckerList;
	protected $m_CheckerDO = "notification.do.NotificationCheckerDO";	
	
	
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
			$checkerLogList[$checker['name']] = strtotime($checker['last_checktime']);
		}
		foreach($this->m_CheckerList as $checker)
		{
			//test is the checker recently called
			if( $checkerLogList[$checker['NAME']] + (int)$checker['MININTERVAL'] < time() ){
			
				$method_name = $checker['MEHTOD'];
				$obj = BizSystem::getObject($checker['SERVICEOBJ']);
				call_user_func(array($obj,$method_name));
				
				//update checker log
				$checker_name = $checker['NAME'];
				if(isset($checkerLogList[$checker['NAME']]))
				{
					//update it
					$checkerDO->updateRecords("[last_checktime]=NOW()","[checker]='$checker_name'");
				}
				else
				{
					//insert it
					$checkerLogArr=array(
						"checker" => $checker_name,
						"last_checktime"=>date('Y-m-d')
					);
					$checkerDO->insertRecord($checkerLogArr);
				}
			}
		}
	}
}
?>