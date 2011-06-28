<?php
class preferenceService
{
    protected $m_Name = "ProfileService";    
    protected $m_PreferenceObj ;    
    protected $m_Preference;

    public function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    }

    protected function readMetadata(&$xmlArr)
    {
        $this->m_PreferenceObj = $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["BIZDATAOBJ"];
    }

    public function InitPreference($user_id)
    {
        $this->m_Preference = $this->InitDBPreference($user_id);
        BizSystem::sessionContext()->setVar("_USER_PREFERENCE", $this->m_Preference);        
        BizSystem::sessionContext()->setVar("LANG",$this->m_Preference['language']);
        BizSystem::sessionContext()->setVar("THEME",$this->m_Preference['theme']);
        BizSystem::sessionContext()->setVar("TIMEZONE",$this->m_Preference['timezone']);
        date_default_timezone_set($this->m_Preference['timezone']);
        return $this->m_Preference;
    }

    public function getPreference($attr=null)
    {    	
        if (!$this->m_Preference)
        {
            $this->m_Preference = BizSystem::sessionContext()->getVar("_USER_PREFERENCE");
        }
        if (!$this->m_Preference)
        {
        		return null;
        }
        if ($attr){
        	if(isset($this->m_Preference[$attr])){
        		return $this->m_Preference[$attr];
        	}else{
        		return null;
        	}
        }
            
        return $this->m_Preference;
    }

    public function SetPreference($preference)
    {
        $this->m_Preference = $preference;
    }
    
 

    protected function InitDBPreference($user_id)
    {
        $do = BizSystem::getObject($this->m_PreferenceObj);
        if (!$do)
            return false;

        $rs = $do->directFetch("[user_id]='$user_id'");
      
        if ($rs)
        {
	        	foreach ($rs as $item)
	        	{        		
	        		$preference[$item["name"]] = $item["value"];        	
	        	}	
        }
        return $preference;
    }

}

?>