<?php 
class CacheForm extends EasyFormGrouping
{
	public $m_ModeStatus;
	
	public function Clear()
	{
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {	
        		$data = $this->getRecoredDetail($id);
        		if(substr($item['Id'],0,7)=='APPDATA')
				{
					$this->DeleteDirectory($data['path'],true);
				}
				else
				{
					$this->DeleteDirectory($data['path'],false);
				}        	
        }
        $this->updateForm();
	}
	
	public function ClearAll(){
		$data = $this->fetchDataGroup(true);
		foreach($data as $group){
			foreach($group as $item){
				if(substr($item['Id'],0,7)=='APPDATA')
				{
					$this->DeleteDirectory($item['path'],true);
				}
				else
				{
					$this->DeleteDirectory($item['path'],false);
				}
			}
		}
		$this->updateForm();
	}
	
	public function ClearBin(){
		$data = $this->getRecoredDetail($this->m_RecordId);
		$this->DeleteDirectory($data['path']);
		$this->updateForm();
	}

   public function outputAttrs(){
   		$result = parent::outputAttrs();
   		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR."cacheService.xml";
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		
   		$this->m_ModeStatus = $configArr["PLUGINSERVICE"]["CACHESETTING"]["ATTRIBUTES"]["MODE"];
   		if($this->m_ModeStatus == 'Enabled'){
   			$result['status'] 	= 'Enabled';
   			$this->m_ModeStatus = 'Enabled';
   		}else{
   			$result['status'] 	= 'Disabled';
   			$this->m_ModeStatus = 'Disabled';	
   		}   		
   		return $result;   	
   }	
	
   public function switchMode(){	   	   	 
   		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR."cacheService.xml";
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		
   		$this->m_ModeStatus = $configArr["PLUGINSERVICE"]["CACHESETTING"]["ATTRIBUTES"]["MODE"];
   		if($this->m_ModeStatus == 'Enabled'){   			   		
   			$newMode = 'Disabled';
   		}else{   		   		
   			$newMode = 'Enabled';	
   		}   		
	   	$configData = file_get_contents($file);
	   	$configData = preg_replace("/CacheSetting\sMode\=\"(.*?)\"/si",
	   								"CacheSetting Mode=\"$newMode\"",
	   								$configData);
	   	file_put_contents($file,$configData);
   		
	   	$this->updateForm();
   }   
   
	private function GetRecoredDetail($recId){
		$data = $this->fetchDataGroup(true);
		foreach($data as $group){
			foreach($group as $item){
				if($item["Id"]==$recId){
					return $item;
				}
			}
		}
	}
	
	public function fetchDataGroup($lite=false)
    {
    	$results = array();
    	
    	//Application data
    	$appdata = array();
    	$i=0;
    	foreach ( glob(CACHE_DATA_PATH.DIRECTORY_SEPARATOR."*",GLOB_ONLYDIR) as $dir){
    		$appdata[$i]['Id'] = "APPDATA_".$i;
    		$appdata[$i]['name'] = ucwords(basename($dir));
    		if(!$lite){
	    		$appdata[$i]['space'] = $this->GetSpaceUsage($dir);
	    		$appdata[$i]['items'] = $this->GetChildItems($dir);
    		}
    		$appdata[$i]['path'] = $dir;
    		$i++; 
    	}
    	if(!$lite)
    	{
    		$results["Application Data"]= $this->m_DataPanel->renderTable($appdata);
    	}
    	else
    	{
    		$results["Application Data"]= $appdata;
    	}
    	//System metadata
    	$metadata = array();
    	$metadata[0]["Id"] = "Metadata";
    	$metadata[0]["name"] = "Metadata";
    	if(!$lite)
    	{
	    	$metadata[0]["space"] = $this->GetSpaceUsage(CACHE_METADATA_PATH);
	    	$metadata[0]["items"] = $this->GetChildItems(CACHE_METADATA_PATH);
    	}
    	$metadata[0]['path'] = CACHE_METADATA_PATH;
    	if(!$lite)
    	{
    		$results["System Metadata"]= $this->m_DataPanel->renderTable($metadata);
    	}
    	else
    	{
    		$results["System Metadata"]= $metadata;
    	}
    	//Complied Template 
    	$tempdata = array();
    	
    	$i=0;
    	foreach ( glob(SMARTY_CPL_PATH.DIRECTORY_SEPARATOR."*",GLOB_ONLYDIR) as $dir){
    		$tempdata[$i]['Id'] = "TEMPDATA_".$i;
    		$tempdata[$i]['name'] = ucwords(basename($dir));
    		 	
    		
    		if(!$lite){
	    		$tempdata[$i]['space'] = $this->GetSpaceUsage($dir);
	    		$tempdata[$i]['items'] = $this->GetChildItems($dir);
    		}
    		$tempdata[$i]['path'] = $dir;
    		$i++; 
    	}

    	if(!$lite)
    	{
    		$results["Complied Template"]= $this->m_DataPanel->renderTable($tempdata);
    	}
    	else
    	{
    		$results["Complied Template"]= $tempdata;
    	}
    	$this->m_RecordId = "APPDATA_1";
    	return $results;
    }
    
    private function GetSpaceUsage($dir){
    	$size = 0;
	    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file){
	        $size+=$file->getSize();
	    }
    	return sprintf("%.1f KB",($size/1024));
    }
    
	private function GetChildItems($dir){		
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		// could use CHILD_FIRST if you so wish
		$i=0;
		foreach ($iterator as $file) {
		   
		    $i++;
		}
		return $i." Items";
    }
    
    private function DeleteDirectory($dir,$deleteItSelf=false){
	   $iterator = new RecursiveDirectoryIterator($dir);
	   foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file)
	   {
		      if ($file->isDir()) {
		         @rmdir($file->getPathname());
		      } else {
		         @unlink($file->getPathname());
		      }
	   		
	   }
	   if($deleteItSelf)
	   {
	   	@rmdir($dir);	
    	}
    	return true;
    }
}
?>
