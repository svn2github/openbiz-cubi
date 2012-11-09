<?php 
class TutorialService 
{	
	const SESSION_VAR_NAME			= "HELP_TUTORAIL_SHOWN";
	
	protected $m_TutorialDO 		= "help.tutorial.do.TutorialDO";
	protected $m_TutorialUserDO 	= "help.tutorial.do.TutorialUserDO";
	protected $m_TutorialForm 		= "help.tutorial.widget.TutorialForm";	
	
	public function checkInstalledVersion()
	{
		$installedVersion = BizSystem::getService("system.lib.ModuleService")->isModuleInstalled("help");
		if(version_compare($installedVersion, "1.1") >=0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function AutoShowTutorial($url,$formObj)
	{
		if(!$this->checkInstalledVersion())
		{
			return false;
		}		
		$tutorialId = $this->getTutorialId($url);
		if(!$tutorialId)
		{
			return false;
		}
		if($this->_checkNeedShowTutorial($tutorialId))
		{
			//show the form		
			$formObj->loadDialog($this->m_TutorialForm,$tutorialId);			
			//set it has been shown in session
			//$this->_setTutorialShownInSession($tutorialId);
		}		
		return true;
	}

	public function getTutorialId($url)
	{
		if(!$this->checkInstalledVersion())
		{
			return 0;
		}
		$tutorialRec = BizSystem::getObject($this->m_TutorialDO)->fetchOne("[url_match]='$url'");
		if(!$tutorialRec)
		{
			foreach(BizSystem::getObject($this->m_TutorialDO)->directfetch("[url_match] LIKE '%.*%'") as $record)
			{
				$match = $record['url_match'];
				$pattern = "@".$match."@si";
				if(preg_match($pattern,$url)){
					$tutorialRec = $record;
					break;
				}
			}
		}
		$tutorialId = $tutorialRec['Id'];
		return (int)$tutorialId;
	}
	
	public function ShowTutorial($tutorialId,$formObj)
	{		
		$formObj->loadDialog($this->m_TutorialForm,$tutorialId);					
		return true;
	}	
	
	protected function _checkNeedShowTutorial($tutorialId)
	{
		$tutorialShown = BizSystem::sessionContext()->getvar(self::SESSION_VAR_NAME);
		if($tutorialShown[$tutorialId])
		{
			return false;
		}
		$userId = BizSystem::getUserProfile("Id");
		$showLog = BizSystem::getObject($this->m_TutorialUserDO)->fetchOne("[tutorial_id]='$tutorialId' AND [user_id]='$userId'");		
		if(!$showLog)
		{
			return true;
		}
		else 
		{
			if($showLog['autoshow']==1)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
	}
	
	
	protected function _setTutorialShownInSession($tutorialId)
	{
		$tutorialShown = BizSystem::sessionContext()->getvar(self::SESSION_VAR_NAME);
		$tutorialShown[$tutorialId]=true;				
		BizSystem::sessionContext()->setVar(self::SESSION_VAR_NAME,$tutorialShown);
	}
	
	public function SetTutorialShown($tutorialId,$showOnNextLogin)
	{
		$this->_setTutorialShownInSession($tutorialId);
		$userId = BizSystem::getUserProfile("Id");
		$logRec = BizSystem::getObject($this->m_TutorialUserDO)->fetchOne("[tutorial_id]='$tutorialId' AND [user_id]='$userId'");
		if(!$logRec)
		{
			$rec = array(
				"tutorial_id" => $tutorialId,
				"user_id"	  => $userId,
				"autoshow"	  => $showOnNextLogin
			);
			BizSystem::getObject($this->m_TutorialUserDO)->insertRecord($rec);
		}
		else{
			$logRec['autoshow']=$showOnNextLogin;
			$logRec->save();
		}
		return true;
	}
	

}
?>