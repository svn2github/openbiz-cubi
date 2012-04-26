<?php 
class MetadataService
{
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
	
	public function getDataObjectInfo($file)
	{		
		$file = MODULE_PATH.DIRECTORY_SEPARATOR.$file;
		if(is_file($file))
		{
			$xmlArr = BizSystem::getXmlArray($file);
			foreach($xmlArr as $key=>$value)
			{
				if(preg_match("/BizData/si", $key, $match))
				{					
					$result = $xmlArr[strtoupper($key)]["ATTRIBUTES"];			
					$result['Id'] = $result['NAME'];
					return $result;
				}
			}			
		}
		return false;
	}
	
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