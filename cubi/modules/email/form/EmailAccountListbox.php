<?php 
require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class EmailAccountListbox extends Listbox{
	
	public $m_ConfigFile = "emailService.xml";
	public $m_ConfigNode = "Account";
	
	public function getFromList(&$list)
    {    	
   	    
    	$file = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.$this->m_ConfigFile;
		if(!is_file($file)){
			return;
		}
		
		$configArr=BizSystem::getXmlArray($file);
		$nodesArr = $configArr["PLUGINSERVICE"]["ACCOUNTS"][strtoupper($this->m_ConfigNode)];
		
    	
		$list = array();
		$i=0;

    	$name = $configArr["PLUGINSERVICE"]["ACCOUNTS"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["NAME"];
		if(!$name){
			for($i=0;$i<count($nodesArr);$i++){
				$list[$i]["txt"]=$nodesArr[$i]["ATTRIBUTES"]["NAME"]." ( ".$nodesArr[$i]["ATTRIBUTES"]["FROMEMAIL"]." )";
				$list[$i]["val"]=$nodesArr[$i]["ATTRIBUTES"]["NAME"];
			}
			
		}else{
			$list[0]["txt"]=$name." ( ".$configArr["PLUGINSERVICE"]["ACCOUNTS"][strtoupper($this->m_ConfigNode)]["ATTRIBUTES"]["FROMEMAIL"]." )";
			$list[0]["val"]=$name;
		}		
		
		return $list;
    }
}
?>