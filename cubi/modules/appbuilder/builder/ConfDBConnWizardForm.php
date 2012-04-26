<?php 
class ConfDBConnWizardForm extends EasyFormWizard
{
	public $m_ConfigFile;
	public $m_ConfigNode;
	public $m_ModeStatus;
	
	
	public function goNext($commit=false)
	{		
		$recId = BizSystem::clientProxy()->getFormInputs('_selectedId');
		$this->m_FixSearchRule = "[Id]='$recId'";
        $rec = $this->fetchData();
        if($rec['STATUS']!=0)
        {			
			parent::goNext(false);
        }
        else
        {
        	$msg = $this->getMessage("MSG_DATABASE_STATUS_INVAILD");
        	$errors = array(
        		"DATABASE"=>$msg
        	);
        	$this->processFormObjError($errors);
        }
	}
	
	
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
		if (strtoupper($this->m_FormType) == "NEW")
            return $this->getNewRule();
            
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
		$result = array();
		
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];
		
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
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
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
		$result = array();				
		
		$name = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		if(!$name){
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){				
					foreach($nodesArr[$i]["ATTRIBUTES"] as $key=>$value){
						$result[$i][$key]=$value;
					}
				}
				$result[$i]["Id"]=$nodesArr[$i]["ATTRIBUTES"]["NAME"];				
			}
			
		}else{
			$this->m_FixSearchRule = "[Id]='$name'";
			$result[0]=$this->fetchData();
		}
				
    	//set default selected record
		if(!$this->m_RecordId){
				$this->m_RecordId=$result[0]["Name"];
		}
		
		//set paging 
		$this->m_TotalRecords = count($result);
			
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		
        if($this->m_CurrentPage > $this->m_TotalPages)
        {
        	$this->m_CurrentPage = $this->m_TotalPages;
        }
            
        if(is_array($result)){
			$result = array_slice($result,($this->m_CurrentPage-1)*$this->m_Range,$this->m_Range);
		}		
		return $result;
	}
	
   public function outputAttrs(){
   		$result = parent::outputAttrs();
   		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
   		$this->m_ModeStatus = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["MODE"];
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
	
	
   
   
   public function deleteRecord($id=null)
    {
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
            
        
        //check prehabit to delete default theme        
        foreach ($selIds as $id)
        {
			if(strtoupper($id)!='DEFAULT'){
        		$this->removeNode($id);    
			}        
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }	
    
    public function TestConnection($id=null){
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
            
        //check prehabit to delete default theme        
        foreach ($selIds as $id)
        {
            $this->testConnStatus($id);            
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();    	
    }
	
	private function testConnStatus($name){
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName)
		{
			$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){					
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){	
						
						$rec = $nodesArr[$i]["ATTRIBUTES"];
						
						$server = $rec['SERVER'];	
			    		$port 	= $rec['PORT'];
			    		$driver	= $rec['DRIVER'];
			    		$username= $rec['USER'];
			    		$password 	= $rec['PASSWORD'];
			    		$charset 	= $rec['CHARSET'];
			    		$dbname 	= $rec['DBNAME'];
						
						$dbconn = @mysql_connect($server.":".$port,$username,$password);
        				$dblist = @mysql_list_dbs($dbconn); 
						
						$connStatus = 0;
						while ($row = @mysql_fetch_array($dblist)){
		        			if($row['Database']==$dbname){
		        				$connStatus = 1; 
		        				break;
		        			}
		        		}
						$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"][$i]["ATTRIBUTES"]['STATUS']=$connStatus;
					}
				}
			}
		}
		else
		{			
			$rec = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"];
						
						$server = $rec['SERVER'];	
			    		$port 	= $rec['PORT'];
			    		$driver	= $rec['DRIVER'];
			    		$username= $rec['USER'];
			    		$password 	= $rec['PASSWORD'];
			    		$charset 	= $rec['CHARSET'];
			    		$dbname 	= $rec['DBNAME'];
						
						$dbconn = @mysql_connect($server.":".$port,$username,$password);
        				$dblist = @mysql_list_dbs($dbconn); 
						
						$connStatus = 0;
						while ($row = @mysql_fetch_array($dblist)){
		        			if($row['Database']==$dbname){
		        				$connStatus = 1; 
		        				break;
		        			}
		        		}
		        		$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]['STATUS']=$connStatus;
			
		}
		$this->saveToXML($configArr);	
	}
    
	private function addNode($nodeArr){
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);		
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		$recordCount = count($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]);
		if(!$recordName && $recordCount){
			array_push($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"] , $nodeArr);			
		}
		elseif($recordCount)
		{
			$oldNodeArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
			$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]=array();
			array_push($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"] , $nodeArr);
			array_push($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"] , $oldNodeArr);
		}else{
			$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"] = $nodeArr;
		}
		$this->saveToXML($configArr);	
		$this->TestConnection($nodeArr["ATTRIBUTES"]["NAME"]);	
	}
	
	private function updateNode($name, $nodeArr){
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName){
			$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){	
						$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"][$i]=$nodeArr;
						break;
					}
				}
			}
		}
		else
		{
			$configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]=$nodeArr;
		}
		$this->saveToXML($configArr);		
		$this->TestConnection($name);
	}
	
	private function removeNode($name){
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName)
		{
			$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
			for($i=0;$i<count($nodesArr);$i++){
				if(is_array($nodesArr[$i]["ATTRIBUTES"])){					
					if($nodesArr[$i]["ATTRIBUTES"]["NAME"]==$name){	
						unset($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"][$i]);
					}
				}
			}
		}
		else
		{
			unset($configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]);
		}
		$this->saveToXML($configArr);
	}
	
	private function checkDupNodeName($nodeName){
		$file = APP_HOME.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		$configArr=BizSystem::getXmlArray($file);
		$recordName = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"]["ATTRIBUTES"]["NAME"];
		if(!$recordName)
		{
			$nodesArr = $configArr["APPLICATION"][strtoupper($this->m_ConfigNode)]["DATABASE"];
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
		$xmldata = $smarty->fetch(BizSystem::getTplFileWithPath("applicationTemplate.xml.tpl", $this->m_Package));
		$service_dir = APP_HOME;
		$service_file = $service_dir.DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		file_put_contents($service_file ,$xmldata);		
		return true;
	}		
}
?>