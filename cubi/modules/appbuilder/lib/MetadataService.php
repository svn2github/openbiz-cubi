<?php 
class MetadataService
{
	/**
	 * 
	 * return array of exsting modules	 
	 * @return array $result
	 */	
	public function listModules()
	{
		$mods = array();
        $dir = MODULE_PATH;
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $filepath = $dir.'/'.$file;
                if (is_dir($filepath)) {
                    $modfile = $filepath.'/mod.xml';
                    if (file_exists($modfile))
                        $mods[] = $file;
                }
            }
            closedir($dh);
        } 
        return $mods;
	}

	/**
	 * 
	 * return array of specified Module XML file attribute 
	 * @return array $result
	 */	
	public function getModuleInfo($module)
	{		
		$modFile = MODULE_PATH.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'mod.xml';
		if(is_file($modFile))
		{
			$xmlArr = BizSystem::getXmlArray($modFile);
			$result = $xmlArr["MODULE"]["ATTRIBUTES"];			
			$result['Id'] = $result['NAME'];
		}
		return $result;
	}	
	
	/**
	 * 
	 * return a list of data object filename in specified module
	 * @param string $module
	 * @return array $result
	 */	
	public function listDataObjects($module)
	{
		$dir = MODULE_PATH.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
		$files = $this->_glob_recursive($dir."*.xml");
		$result = array();
		foreach ($files as $file)
		{
			$file = str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$file);
			if($this->getDataObjectInfo($file))
			{				
				$result[] = $file;
			}
		}
		return $result;
	}

	/**
	 * 
	 * return array of specified Data Objecct attribute
	 * @param string $file
	 * @return array $result
	 */		
	public function getDataObjectInfo($file)
	{		
		$file = MODULE_PATH.DIRECTORY_SEPARATOR.$file;
		if(is_file($file))
		{
			$doc = new DomDocument();
			$test = @$doc->load($file);								
			if (!$test)
			{
				return false;
			}			
			
			$xmlArr = BizSystem::getXmlArray($file);
			foreach($xmlArr as $key=>$value)
			{
				if(preg_match("/BizData/si", $key, $match))
				{					
					$result = $xmlArr[strtoupper($key)]["ATTRIBUTES"];			
					$result['Id'] = $result['NAME'];
					
					$file = str_replace(MODULE_PATH.DIRECTORY_SEPARATOR, "", $file);					
					preg_match("|(.*?)/(.*)/.*\.xml|si",$file,$match);
					$folder = $match[2];
					$result['FOLDER'] = $folder;
					$result['PACKAGE'] = $match[1].'.'.str_replace('/','.',$folder);
					return $result;
				}
			}			
		}
		return false;
	}
	
	/**
	 * 
	 * return a list of form metadata filename in specified module
	 * @param string $module
	 * @return array $result
	 */
	public function listFormObjects($module)
	{
		$dir = MODULE_PATH.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
		$files = $this->_glob_recursive($dir."*.xml");
		$result = array();
		foreach ($files as $file)
		{
			$file = str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$file);
			if($this->getFormObjectInfo($file))
			{				
				$result[] = $file;
			}
		}
		return $result;
	}
	
	/**
	 * 
	 * return array of specified Form Objecct attribute
	 * @param string $file
	 * @return array $result
	 */	
	public function getFormObjectInfo($file)
	{		
		$file = MODULE_PATH.DIRECTORY_SEPARATOR.$file;
		if(is_file($file))
		{			
			$doc = new DomDocument();
			$test = @$doc->load($file);								
			if (!$test)
			{
				return false;
			}
			$xmlArr = BizSystem::getXmlArray($file);			
			foreach($xmlArr as $key=>$value)
			{
				if(preg_match("/EasyForm/si", $key, $match))
				{					
					$result = $xmlArr[strtoupper($key)]["ATTRIBUTES"];			
					$result['Id'] = $result['NAME'];
					
					$file = str_replace(MODULE_PATH.DIRECTORY_SEPARATOR, "", $file);					
					preg_match("|(.*?)/(.*)/.*\.xml|si",$file,$match);
					$folder = $match[2];
					$result['FOLDER'] = $folder;
					$result['PACKAGE'] = $match[1].'.'.str_replace('/','.',$folder);
					return $result;
				}
			}	
		
		}
		return false;
	}	
	
	/**
	 * 
	 * return array of files for specified folder
	 */	
    private function _glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
       
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, $this->_glob_recursive($dir.'/'.basename($pattern), $flags));
        }
       
        return $files;
    }	
}
?>