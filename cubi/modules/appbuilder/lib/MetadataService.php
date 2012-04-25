<?php 
class MetadataService
{
	public function ListModules()
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
}
?>