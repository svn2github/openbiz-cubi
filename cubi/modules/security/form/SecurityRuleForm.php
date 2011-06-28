<?php 
class SecurityRuleForm extends EasyForm
{
	public $m_ConfigFile;
	public $m_ConfigNode;
	public $m_ModeStatus;
	
	protected function readMetadata(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		$this->m_ConfigFile = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CONFIGFILE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CONFIGFILE"] : null;
		$this->m_ConfigNode = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CONFIGNODE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CONFIGNODE"] : null;
		
	}

	public function getActiveRecord($recId=null)
    {
        if ($this->m_ActiveRecord != null)
        {
            if($this->m_ActiveRecord['Id'] != null)
            {
                return $this->m_ActiveRecord;
            }
        }

        if ($recId==null || $recId=='')
            $recId = BizSystem::clientProxy()->getFormInputs('_selectedId');
        if ($recId==null || $recId=='')
            return null;
        $this->m_RecordId = $recId;
		$this->m_FixSearchRule = "[Id]='$recId'";
        $rec=$this->fetchData();
        $this->m_DataPanel->setRecordArr($rec);
        $this->m_ActiveRecord = $rec;
        return $rec;
    }	
	
	public function fetchData(){
		if ($this->m_FormType == "NEW")
            return $this->getNewRule();
            
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$nodesArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
		$result = array();
		
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];
		
		$recordName = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName){
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){				
						foreach($nodesArr[$i]["ATTRIBUTES"] as $key=>$value){
							$result[$key]=$value;
						}
						$result["Id"]=$nodesArr[$i]["ATTRIBUTES"]["NAME"];
						
					}else{
						continue;
					}
				}
				preg_match("/([0-9]{2})([0-9]{2})\-([0-9]{2})([0-9]{2})/si",$result["EFFECTIVETIME"],$match);
				$result["EFFECTIVETIME_Display"]=$match[1].":".$match[2]." - ".$match[3].":".$match[4];
				$result["starthour"] = $match[1];
				$result["starttime"] = $match[2];
				$result["endhour"] = $match[3];
				$result["endtime"] = $match[4];
			}	
		}
		else
		{
			
				if(is_array($nodesArr["ATTRIBUTES"])){
					if($nodesArr["ATTRIBUTES"]["NAME"]==$name){				
						foreach($nodesArr["ATTRIBUTES"] as $key=>$value){
							$result[$key]=$value;
						}
					}
				}
				$result["Id"]=$nodesArr["ATTRIBUTES"]["NAME"];
				preg_match("/([0-9]{2})([0-9]{2})\-([0-9]{2})([0-9]{2})/si",$result["EFFECTIVETIME"],$match);
				$result["EFFECTIVETIME_Display"]=$match[1].":".$match[2]." - ".$match[3].":".$match[4];
				$result["starthour"] = $match[1];
				$result["starttime"] = $match[2];
				$result["endhour"] = $match[3];
				$result["endtime"] = $match[4];
					
		}	
		$this->m_RecordId = $name;
		return $result;
		 
	}
	
	public function fetchDataSet(){
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$nodesArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
		$result = array();				
		
		$name = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		if(!$name){
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){				
					foreach($nodesArr[$i]["ATTRIBUTES"] as $key=>$value){
						$result[$i][$key]=$value;
					}
				}
				$result[$i]["Id"]=$nodesArr[$i]["ATTRIBUTES"]["NAME"];
				preg_match("/([0-9]{2})([0-9]{2})\-([0-9]{2})([0-9]{2})/si",$result[$i]["EFFECTIVETIME"],$match);
				$result[$i]["EFFECTIVETIME_Display"]=$match[1].":".$match[2]." - ".$match[3].":".$match[4];
			}
			
		}else{
			$this->m_FixSearchRule = "[Id]='$name'";
			$result[0]=$this->fetchData();
		}
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Name"];
		}
		return $result;
	}
	
   public function outputAttrs(){
   		$result = parent::outputAttrs();
   		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
   		$this->m_ModeStatus = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["MODE"];
   		$result['status'] = $this->m_ModeStatus;
   		return $result;   	
   }
      
   protected function getNewRule()
    {
        $recArr = $this->readInputRecord();        
        // load default values if new record value is empty
        $defaultRecArr = array();
        foreach ($this->m_DataPanel as $element)
        {
            if ($element->m_FieldName)
            {
                $defaultRecArr[$element->m_FieldName] = $element->getDefaultValue();
            }
        }

        foreach ($recArr as $field => $val)
        {
            if ( $defaultRecArr[$field] != "" && $val=="")
            {
                $recArr[$field] = $defaultRecArr[$field];
            }
        }
        if(count($recArr)==0){
        	$recArr=$defaultRecArr;
        }
        
        return $recArr;
    }	
    
	public function InsertRecord()
	{
        $recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
                           
            
        try
        {
        	$this->ValidateForm();
	        $name = $recArr['NAME'];
	        $this->m_ValidateErrors = array();
	        if($this->checkDupNodeName($name)){	        			       	
	        		$errorMessage = $this->getMessage("FORM_NODE_EXIST",array("fld_name"));
	                $this->m_ValidateErrors["fld_name"] = $errorMessage;
	        }
	        if (count($this->m_ValidateErrors) > 0)
	        {
	            throw new ValidationException($this->m_ValidateErrors);
	        }
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
		$recArr["EFFECTIVETIME"] = $recArr["starthour"].$recArr["starttime"]."-".$recArr["endhour"].$recArr["endtime"];
		$nodeArr = array(
			"ATTRIBUTES" => null,
			"VALUE" => null
		);        
		foreach($recArr as $key=>$value){
			$nodeArr["ATTRIBUTES"][strtoupper($key)]=$value;
		}       
        $this->addNode($nodeArr);
        $this->m_RecordId = $recArr["NAME"];
        $this->processPostAction();		
	}    

	public function UpdateRecord()
	{
		$recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
		
        preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];		
        
		try
        {
        	$this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        $recArr["EFFECTIVETIME"] = $recArr["starthour"].$recArr["starttime"]."-".$recArr["endhour"].$recArr["endtime"];
		$nodeArr = array(
			"ATTRIBUTES" => null,
			"VALUE" => null
		);        
		foreach($recArr as $key=>$value){
			$nodeArr["ATTRIBUTES"][strtoupper($key)]=$value;
		}		
		$nodeArr["ATTRIBUTES"]["NAME"]=$name;
        $this->updateNode($name, $nodeArr);
        
		$this->m_RecordId = $name;
        $this->processPostAction();		
	}	
	
	
   public function switchMode(){	   	   	 
   		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		
		$this->m_ModeStatus = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["MODE"];		
		if($this->m_ModeStatus == 'Enabled')
	   	{
	   		$status = "Disabled";
	   	}
	   	else
	   	{
	   		$status = "Enabled";
	   	}
	   	$this->m_ModeStatus = $status;
		
		$configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["MODE"] = $status;
		
	   	$this->saveToXML($configArr);
	   	$this->updateForm();
   }
   
   public function deleteRecord($id=null)
    {
        if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".delete"))
            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
            
        //check prehabit to delete default theme        
        foreach ($selIds as $id)
        {
            $this->removeNode($id);            
        }
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }	
	
	private function addNode($nodeArr){
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);		
		$recordName = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		$recordCount = count($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]);
		if(!$recordName && $recordCount){
			array_push($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"] , $nodeArr);			
		}
		elseif($recordCount)
		{
			$oldNodeArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
			$configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]=array();
			array_push($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"] , $nodeArr);
			array_push($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"] , $oldNodeArr);
		}else{
			$configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"] = $nodeArr;
		}
		$this->saveToXML($configArr);		
	}
	
	private function updateNode($name, $nodeArr){
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName){
			$nodesArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){	
						$configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"][$i]=$nodeArr;
						break;
					}
				}
			}
		}
		else
		{
			$configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]=$nodeArr;
		}
		$this->saveToXML($configArr);		
	}
	
	private function removeNode($name){
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName)
		{
			$nodesArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){	
						unset($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"][$i]);
					}
				}
			}
		}
		else
		{
			unset($configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]);
		}
		$this->saveToXML($configArr);
	}
	
	private function checkDupNodeName($nodeName){
		$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName)
		{
			$nodesArr = $configArr["PLUGINSERVICE"]["SECURITY"][strtoupper($this->m_ConfigNode)]["RULE"];
			$result = array();
			
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$nodeName){				
						return true;
					}
				}
			}
		}
		else
		{
			if($recordName==$nodeName){
				return true;
			}
		}	
		return false;	
	}
	
	private function saveToXML($data){
		$smarty = BizSystem::getSmartyTemplate();
		$smarty->assign("data", $data);
		$xmldata = $smarty->fetch(BizSystem::getTplFileWithPath("serviceTemplate.xml.tpl", $this->m_Package));
		$service_dir = MODULE_PATH.DIRECTORY_SEPARATOR."service";
		$service_file = $service_dir.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		file_put_contents($service_file ,$xmldata);		
		return true;
	}
}
?>
