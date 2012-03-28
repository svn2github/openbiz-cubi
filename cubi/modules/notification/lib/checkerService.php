<?php 
class checkerService extends MetaObject
{
	protected $m_CheckerList;
	
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
		foreach($this->m_CheckerList as $checker)
		{
			//test is the checker recently called
			
			$method_name = $checker['MEHTOD'];
			$obj = BizSystem::getObject($checker['SERVICEOBJ']);
			call_user_func(array($obj,$method_name));
		}
	}
}
?>