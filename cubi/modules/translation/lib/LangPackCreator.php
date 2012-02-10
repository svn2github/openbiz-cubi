<?php
class LangPackCreator
{
	public $module = '*';
	public $lang;
	public $systemOnly = false;
	protected $comments = array();
	protected $menus = array();
	protected $acls = array();
	
    public function __construct($lang)
    {
    	$this->lang = $lang;
    }
    
    public function createNew($translate = false)
    {
    	$result = array();
    	
    	$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang;
		if(!is_dir($lang_dir)){
			if(CLI){
				echo "Create language directory: $lang".PHP_EOL;
			}
			array_push($result,"Create language directory: $lang");
    		@mkdir($lang_dir);
		}
    	if ($this->systemOnly == false) {
	    	//load modules strings
	    	$module_strings= array();
	    	foreach (glob(MODULE_PATH.DIRECTORY_SEPARATOR.$this->module,GLOB_ONLYDIR) as $dir)
	    	{
	    		$module_name = str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$dir);
	    		array_push($result,"Module: ".ucfirst($module_name));
	    		if(CLI){
					echo "Module: ".ucfirst($module_name).PHP_EOL;
				}
				
	    		$strings = $this->getStringsFromXml($module_name);
	    		$module_strings[strtoupper($module_name)]["METADATA"]=$strings;
	    		$module_strings[strtoupper($module_name)]["MENU"]=$this->menus;// menu strings
	    		$module_strings[strtoupper($module_name)]["ACL"]=$this->acls; // acl strings
	    		array_push($result,"Getting Strings from Metadata: ".count($strings)." strings");
	    		if(CLI){
					echo "Getting Strings from Metadata: ".count($strings)." strings".PHP_EOL;
				}
				
	    		$strings = $this->getStringsFromMsg($module_name);
	    		$module_strings[strtoupper($module_name)]["MESSAGE"]=$strings;
	    		
	    		array_push($result,"Getting Strings from Message file: ".count($strings)." strings");
	    		if(CLI){
					echo "Getting Strings from Message file: ".count($strings)." strings".PHP_EOL;
				}
				
	    		$strings = $this->getStringsFromTemplate($module_name);
	    		$module_strings[strtoupper($module_name)]["TEMPLATE"]=$strings;    		
	    		array_push($result,"Getting Strings from Templates: ".count($strings)." strings");
	    		if(CLI){
					echo "Getting Strings from Templates: ".count($strings)." strings".PHP_EOL;
				}
				
	    		array_push($result,"");
	    		if(CLI){
					echo PHP_EOL;
				}
	    	}
    	}
    	
    	if ($this->module == '*') {
    		//load general strings
	    	if(CLI){
				echo "Create System Strings: $lang".PHP_EOL;
			}
	    	array_push($result,"General System:");
	    	$system_strings = $this->getStringsFromSystem();
	    	/*
	    	//load menu strings
	    	if(CLI){
				echo "Create System Menu Strings: $lang".PHP_EOL;
			}
	    	array_push($result,"System Menu:");
	    	$menu_strings = $this->getStringsFromMenu();
	    	
	    	//load acl strings
	    	if(CLI){
				echo "Create System ACL Strings: $lang".PHP_EOL;
			}
	    	array_push($result,"System ACL:");
	    	$acl_strings = $this->getStringsFromACL();
	    	*/
    	}
    	
    	$strings=array();
    	$strings["Module"] 	= $module_strings;
    	//$strings["Menu"]	= $menu_strings;
    	$strings["System"] 	= $system_strings;
    	//$strings["ACL"] 	= $acl_strings;
    	
    	if($translate){
    		$this->translateStrings($strings);
    	} 
    	$this->loadPack($strings);   
    	$this->geneFiles($strings);   	
    	return $result;
    	
    }
    
    public function loadPack(&$arr)
    {
    	$lang = $this->lang;
    	if(!is_array($arr)){
			return;
		}
    	if(CLI){
			echo "Loading translation files:".PHP_EOL;
		} 
		$lang = $this->lang;  
		if ($this->systemOnly == false) {	
			foreach($arr["Module"] as $key=>$value){  
				$module_name = strtolower($key);
				$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."mod.".$module_name.".ini";
				 
				if(is_file($module_filename)){
					$strArr = parse_ini_file($module_filename,true);
					if(CLI){
						echo "  Loading translation files: ".basename($module_filename)."".PHP_EOL;
					}				
					foreach($strArr as $section=>$strs){				
						foreach($strs as $str_key=>$str_value)
						{
							if($arr["Module"][$key][$section][$str_key] != $str_value){
								$arr["Module"][$key][$section][$str_key] = $str_value;
							}
						}
					}
				}
			}
		}
		
		if ($this->module == '*') {
			//load menu.ini
			$module_name = "SYSTEM_MENU";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."menu.ini";		
			if(is_file($module_filename)){
				$strArr = parse_ini_file($module_filename);
				if(is_array($arr["Menu"])){
					foreach($arr["Menu"] as $key=>$value){
						if($arr["Menu"][$key] != $strArr[$key]){
							$arr["Menu"][$key]=$strArr[$key];
						}
					}
				}
			}
	
	    	//load acl.ini
			$module_name = "SYSTEM_ACL";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."acl.ini";		
			if(is_file($module_filename)){
				$strArr = parse_ini_file($module_filename);
				if(is_array($arr["Menu"])){
					foreach($arr["ACL"] as $key=>$value){
						if($arr["ACL"][$key] != $strArr[$key]){
							$arr["ACL"][$key]=$strArr[$key];
						}
					}
				}
			}		
			
			//load system.ini
			$module_name = "SYSTEM";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."system.ini";		
			if(is_file($module_filename)){
			$strArr = parse_ini_file($module_filename,1);
				foreach($strArr as $key=>$value){
					foreach($value as $str_key=>$str_value){
						if($arr["System"][$key][$str_key] != $strArr[$key][$str_key]){
							$arr["System"][$key][$str_key]=$strArr[$key][$str_key];
						}
					}
				}
			}
		}
		if(CLI){
			echo PHP_EOL;
		} 
		return $arr;
    }
    
    public function geneFiles(&$arr)    
    {
    	if(CLI){
			echo "Generate translation files:".PHP_EOL;
		} 
    	$lang = $this->lang;
    	if ($this->systemOnly == false) {
	    	foreach($arr["Module"] as $key=>$value){    		
	    		$module_name = strtolower($key);
	    		$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."mod.".$module_name.".ini";
	    		$file_data="";
	    		foreach ($value as $section=>$data){
	    			$file_data .= "[$section]\n";
	    			foreach($data as $string_name=>$string_value){
	    				if ($this->comments[$string_name])
	    					$file_data .= $this->comments[$string_name];
	    				$file_data .= "$string_name=\"$string_value\"\n";
	    			}
	    			$file_data .= "\n";
	    		}
	    		if(CLI){
					echo "  Generate translation file for module: mod.$module_name.ini ( ".strlen($file_data)." Bytes )".PHP_EOL;
				}    		
				@unlink($module_filename);
	    		file_put_contents($module_filename,$file_data);
	    	}
    	}
    	
    	if ($this->module == '*') {
	    	//generate menu.ini
	    	$module_name = "SYSTEM_MENU";
	    	$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."menu.ini";
	    	$file_data="[MENU]\n";
	    	if(is_array($arr["Menu"])){
		    	foreach ($arr["Menu"] as $string_name=>$string_value){
		    		if ($this->comments[$string_name])
		    			$file_data .= $this->comments[$string_name];
		    		$file_data .= "$string_name=\"$string_value\"\n";    			
		    	}
	    	}
	    	if(CLI){
				echo "  Generate translation file for system menu: menu.ini ( ".strlen($file_data)." Bytes )".PHP_EOL;
			}  
			//print_r($arr["Menu"]);
	    	@unlink($module_filename);
	    	file_put_contents($module_filename,$file_data);
	    	
	    	//generate acl.ini
	    	$module_name = "SYSTEM_ACL";
	    	$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."acl.ini";
	    	$file_data="[ACL]\n";
	    	if(is_array($arr["ACL"])){
		    	foreach ($arr["ACL"] as $string_name=>$string_value){
		    		if ($this->comments[$string_name])
		    			$file_data .= $this->comments[$string_name];
		    		$file_data .= "$string_name=\"$string_value\"\n";    			
		    	}
	    	}
	    	if(CLI){
				echo "  Generate translation file for system ACL: acl.ini ( ".strlen($file_data)." Bytes )".PHP_EOL;
			}  
	    	@unlink($module_filename);
	    	file_put_contents($module_filename,$file_data);
	    	
	    	//generate system.ini
	    	$module_name = "SYSTEM";
	    	$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."system.ini";
	    	$file_data="";
	    	foreach($arr['System'] as $section=>$strArr)
	    	{
		    	$file_data.="[$section]\n";
		    	foreach ($arr["System"][$section] as $string_name=>$string_value){
		    		if ($this->comments[$string_name])
	    				$file_data .= $this->comments[$string_name];
		    		$file_data .= "$string_name=\"$string_value\"\n";    			
		    	}
		    	$file_data .= "\n";
	    	}
	    	if(CLI){
				echo "  Generate translation file for system: system.ini ( ".strlen($file_data)." Bytes )".PHP_EOL;
			} 
	    	@unlink($module_filename);
	    	file_put_contents($module_filename,$file_data);
    	}
    	if(CLI){
			echo PHP_EOL;
		} 
    	return ;
    	
    }
    
    public function translateStrings(&$arr){
    	if(CLI){
			echo "Translation language package strings:".PHP_EOL;
		}
		//$orgArr = $arr;
		//$this->loadPack($orgArr);
    	require_once('Dictionary.php');
    	$lang = $this->lang;
    	$locale = explode("_", $lang);
    	$target_lang=strtolower($locale[0]);
    	$dictionary = new Dictionary('en',$target_lang);

    	if ($this->systemOnly == false) {
	    	foreach($arr["Module"] as $key=>$value){  
				$module_name = strtolower($key);
				foreach($arr["Module"][$key] as $section=>$value){
					$str_count = count($arr["Module"][$key][$section]);
					$i=0;
					foreach($arr["Module"][$key][$section] as $str_key => $str_value){
						$i++;
						//if($arr["Module"][$key][$section][$str_key]==$orgArr["Module"][$key][$section][$str_key])
						{
							$str_value_translated = $dictionary->translate($str_value);
							if($str_value_translated){
								$arr["Module"][$key][$section][$str_key]=$str_value_translated;
								if(CLI){
									if($target_lang=='zh'){
										$str_value_translated = iconv("UTF-8","GB2312",$str_value_translated);
									}
									echo " $key: (".sprintf('%0'.strlen($str_count).'d',$i)."/$str_count) Translation string : $str_value => $str_value_translated".PHP_EOL;
								}
							}
						}
					}
				}
	    	}
    	}
    	
    	if ($this->module == '*') {
	    	/*
    		//load menu.ini
	    	if(CLI){
				echo "Translation menu strings:".PHP_EOL;
			}
			$module_name = "SYSTEM_MENU";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."menu.ini";		
			if(is_file($module_filename)){
				//$strArr = parse_ini_file($module_filename);
				$i=0;
				$str_count = count($arr["Menu"]);
				foreach($arr["Menu"] as $key=>$value){
					$i++;
					//if($arr["Menu"][$key] == $strArr[$key])
					{
						$str_value_translated = $dictionary->translate($value);
						if($str_value_translated){
							$arr["Menu"][$key]=$str_value_translated;
							if(CLI){
								if($target_lang=='zh'){
									$str_value_translated = iconv("UTF-8","GB2312",$str_value_translated);
								}
								echo " $key: (".sprintf('%0'.strlen($str_count).'d',$i)."/$str_count) Translation string : $value => $str_value_translated".PHP_EOL;
							}
						}
					}
				}
			}
			
	    	//load acl.ini
	    	if(CLI){
				echo "Translation ACL strings:".PHP_EOL;
			}
			$module_name = "SYSTEM_ACL";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."acl.ini";		
			if(is_file($module_filename)){
				//$strArr = parse_ini_file($module_filename);
				$i=0;
				$str_count = count($arr["ACL"]);
				foreach($arr["ACL"] as $key=>$value){
					$i++;
					//if($arr["ACL"][$key] == $strArr[$key])
					{
						$str_value_translated = $dictionary->translate($value);
						if($str_value_translated){
							$arr["ACL"][$key]=$str_value_translated;
							if(CLI){
								if($target_lang=='zh'){
									$str_value_translated = iconv("UTF-8","GB2312",$str_value_translated);
								}
								echo " $key: (".sprintf('%0'.strlen($str_count).'d',$i)."/$str_count) Translation string : $value => $str_value_translated".PHP_EOL;
							}
						}
					}
				}
			}
			*/
			//load system.ini
	    	if(CLI){
				echo "Translation System strings:".PHP_EOL;
			}
			$module_name = "SYSTEM";
			$module_filename =  APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$this->lang.DIRECTORY_SEPARATOR."system.ini";		
			if(is_file($module_filename)){
				//$strArr = parse_ini_file($module_filename,1);
				//foreach($strArr as $key=>$value){
				foreach($arr["System"] as $key=>$value){
					$i=0;
					$str_count = count($arr["System"][$key]);
					foreach($value as $str_key=>$str_value) {
						$i++;
						//if($arr["System"][$key][$str_key] == $strArr[$key][$str_key])
						{
							$str_value_translated = $dictionary->translate($str_value);
							if($str_value_translated){
								$arr["System"][$key][$str_key]=$str_value_translated;
								if($target_lang=='zh'){
									$str_value_translated = iconv("UTF-8","GB2312",$str_value_translated);
								}
								echo " $key: (".sprintf('%0'.strlen($str_count).'d',$i)."/$str_count) Translation string : $str_value => $str_value_translated".PHP_EOL;
							}
						}
					}
				}
			}
    	}
    	if(CLI){
			echo PHP_EOL;
		}
		
		// update dictionary file
		$dictionary->update();
		
    	return $arr;
    }
    
    private function escapeINIValue($value){
    	$value = str_replace("[",'\[',$value);
    	$value = str_replace("]",'\]',$value);
    	$value = str_replace("\"",'\"',$value);
    	
    	return $value;
    }

    
    private function isTranslatableAttr($name){

    	switch($name){
    		case "TEXT":
    		case "DESCRIPTION":
    		case "LABEL":
    		case "TITLE":
    		case "CONTEXTMENU":
            case "DEFAULTVALUE":
            case "ELEMENTSET":
            case "BLANKOPTION":
    			$result = true;
    			break;
    			
    		default:
    			$result = false;
    			break;
    	}
    	return $result;
    }
    private function isTranslatableValue($name,$value=null){
        if(strpos($name,'{')||strpos($name,'$')||strpos($value,'@')){
    		return false;
    	}
    	if(is_string($value)){
	    	if(strpos($value,'{')||strpos($value,'$')||strpos($value,'@')){
	    		return false;
	    	}
    	}
    	
    	return true;
    }
    private function analystXML($xmlArr,$nodePath=null,&$result=array()){    	    	
    	if(count($xmlArr)){
	   
    		foreach($xmlArr as $nodeName => $xmlNode){
    			//echo $nodeName.",".count($xmlNode).nl;
    			if($nodeName!=="ATTRIBUTES" && count($xmlNode)>0){
    				if(is_array($xmlNode)){
	    				if($xmlNode["ATTRIBUTES"]["NAME"]){
	    					$newNodePath = $nodePath."_".(string)strtoupper($xmlNode["ATTRIBUTES"]["NAME"]);
	    				}else{
	    					//$newNodePath = $nodePath. "_".$nodeName;
	    					$newNodePath = $this->getNewNodePath($nodePath, $nodeName);
	    					
	    				}
    				
	    				if(substr($newNodePath,0,1)=="_"){
	    					$newNodePath = substr($newNodePath,1);
	    				}
	    				if($this->isTranslatableValue($newNodePath)){
	    					$this->analystXML($xmlNode,$newNodePath,$result);
	    				}
    				}
    			}elseif((string)$nodeName==(string)"ATTRIBUTES" ){    				
    				foreach($xmlNode as $key => $value){    					
    					if($this->isTranslatableAttr($key) && $this->isTranslatableValue($key,$value)){
    						$result[$this->escapeINIValue($nodePath."_".(string)$key)] = $this->escapeINIValue($value);
    					}    				
    				}
    			}elseif(is_numeric($nodeName)){
    				foreach($xmlNode as $nodeChild){
    					if(is_array($nodeChild)){
		    				foreach($nodeChild as $key => $value){
		    					if($key!="ATTRIBUTES"){
			    					$newNodePath = $nodePath."_".(string)strtoupper($nodeChild["NAME"]);
			    					if($this->isTranslatableAttr($key)  && $this->isTranslatableValue($key,$value) ){
			    						$result[$this->escapeINIValue($newNodePath."_".(string)$key)] = $this->escapeINIValue($value);
			    					}
		    					}else{
		    						$this->analystXML($nodeChild,$newNodePath."_".strtoupper($value["NAME"]),$result);
		    					}		    				
		    				}
    					}
    				}
    			}
    		}
    	}
    	return $result;
    }
    
    private function getNewNodePath($nodePath, $nodeName)
    {
    	//echo "getNewNodePath: $nodePath, $nodeName".nl;
    	if ($nodeName === 'SELECTION')
    		return $nodeName;
    	if (strpos($nodePath,'SELECTION')===0) {
            return $nodePath."_$nodeName";
    	}
    	return $nodePath;
    }
    
    private function mergeStrings($strings)
    {
    	if (empty($strings))
    		return $strings;
    	// ignore empty string
    	$stringGrp = array();
    	$_strings = array();
    	foreach ($strings as $k=>$v) {
    		if (!empty($v)) {
	   			$_strings[$k] = $strings[$k];
	   			$stringGrp[$v][] = $k;
    		}
    	}
    	
    	// merge same text to key STRING_TEXT
    	foreach ($stringGrp as $v=>$keys) {
    		if (count($keys)>1) {
    			$comments = "";
    			foreach ($keys as $k) {
    				unset($_strings[$k]);
    				$comments .= "; ".$k.PHP_EOL;
    			}
    			$newkey = strtoupper('STRING_'.md5($v));
    			$_strings[$newkey] = $v;
    			$this->comments[$newkey] = $comments;
    		}
    		else {
    			$k = $keys[0];
    			$comments = "; ".$v.PHP_EOL;
    			$this->comments[$k] = $comments;
    		}
    	}
    	//print_r($this->comments); exit;
    	return $_strings;
    }
    
    private function getStringsFromXml($module)
    {
    	$strings = array();
    	$dir = MODULE_PATH.DIRECTORY_SEPARATOR.$module;
    	$filelist = $this->getFileList($dir,".xml");
    	libxml_use_internal_errors(true);
    	foreach($filelist as $file){
    		$shortFileName = str_replace($dir.DIRECTORY_SEPARATOR,"",$file);
    		if(CLI){
				echo "   Analyst XML File : ".str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$file)." ".PHP_EOL;
			}
			
    		$xml = simplexml_load_file($file);
    		if($xml){
    			if ($shortFileName == "mod.xml") {
    				$this->analyzeModXML($xml, $module);
    			}
    			else {
					$xmlArr = BizSystem::getXmlArray($file);
		    		$tmp = $this->analystXML($xmlArr);
		    		$strings = array_merge($strings,$tmp);
    			}
    		}
    	}

    	return $this->mergeStrings($strings);
    }
    
    private function analyzeModXML($xml, $module)
    {
    	$this->analyzeMenu($xml, $module);
    	$this->analyzeACL($xml, $module);
    }
    
	private function analyzeMenu($xml, $module)
    {	
    	if(CLI){
    		echo "      Analyze Module Menu.".PHP_EOL;
    	}
    	$this->menus = array();
    	if (isset($xml->Menu) && isset($xml->Menu->MenuItem))
    	{
            foreach ($xml->Menu->MenuItem as $m) {
            	$this->analyzeMenuItem($m, $module);
            }   
    	}
    	return true;
    }
    
    private function analyzeMenuItem($menuItem, $module)
    {
    	$name = $menuItem['Name'].'';
    	$title = $menuItem['Title'].'';
    	$description = $menuItem['Description'].'';
    	
    	$key = strtoupper('_MENU_'.$name."_TITLE");
    	$this->menus[$key] = $title;
    	$this->comments[$key] = "; $title".PHP_EOL;
    	if (!empty($description)) {
    		$key = strtoupper('_MENU_'.$name."_DESCRIPTION");
    		$this->menus[$key] = $description;
    		$this->comments[$key] = "; $description".PHP_EOL;
    	} 

        foreach ($menuItem->MenuItem as $m) {
        	$this->analyzeMenuItem($m,$module);
        }
        return true;
    }
    
	private function analyzeACL($xml, $module)
    {
        if(CLI){
    		echo "      Analyze Module ACL.".PHP_EOL;
    	}
    	if (isset($xml->ACL) && isset($xml->ACL->Resource))
        {
            foreach ($xml->ACL->Resource as $res)
            {
                $resName = $res['Name'].'';
                foreach ($res->Action as $act)
                {
                    $name = $act['Name'].'';
                    $key = strtoupper('ACL_'.$resName.'.'.$name."_DESCRIPTION");
                    $description = $act['Description'].'';
			    	if (!empty($description)) {
			    		$this->acls[$key] = $description;
			    		$this->comments[$key] = "; $description".PHP_EOL;
			    	}
                }
            }
        }
    }
    
    private function getStringsFromMsg($module,$dir=null)
    {
    	if(!$dir){
    		$dir = MODULE_PATH.DIRECTORY_SEPARATOR.$module;
    	}
    	$filelist = $this->getFileList($dir,"((.msg)|(.ini))"); 
    	$strings=array(); 
    	foreach($filelist as $file){
    		if(CLI){
				echo "   Analyst Message File: ".str_replace(APP_HOME.DIRECTORY_SEPARATOR,"",str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$file))." ".PHP_EOL;
			}			
			$iniArr = parse_ini_file($file);	    		
    		$strings = array_merge($strings,$iniArr);
    	}    	
    	return $this->mergeStrings($strings);
    }    

    private function getStringsFromTemplate($module,$dir=null)
    {
    	// smarty open tag
		$ldq = preg_quote('{');
		
		// smarty close tag
		$rdq = preg_quote('}');
		
		// smarty command
		$cmd = preg_quote('t');
		if(!$dir){
     		$dir = MODULE_PATH.DIRECTORY_SEPARATOR.$module;
		}
    	$filelist = $this->getFileList($dir,"((tpl)|(html)|(htm))");   	
    	$strings=array(); 
    	foreach($filelist as $file){
    		if(CLI){
				echo "   Analyst Template File: ".str_replace(APP_HOME.DIRECTORY_SEPARATOR,"",str_replace(MODULE_PATH.DIRECTORY_SEPARATOR,"",$file))." ".PHP_EOL;
			}			
    			$content = @file_get_contents($file);
				if (empty($content)) {
					continue;
				}
				
				preg_match_all(
						"/{$ldq}\s*({$cmd})\s*([^{$rdq}]*){$rdq}([^{$ldq}]*){$ldq}\/\\1{$rdq}/",
				$content,
				$matches
				);
				$tmp=array();
				foreach ($matches[3] as $match)
				{
					$match_data=str_replace("\n",'\n',$match);
					$match_data=str_replace("\r",'',$match_data);
					//$tmp[strtoupper($module)."_".strtoupper(md5($match))]=$match_data;
					$tmp["STRING_".strtoupper(md5($match))]=$match_data;
				}
				$strings = array_merge($strings,$tmp);
    	}    	
    	return $this->mergeStrings($strings);
    }   

    private function getStringsFromMenu()
    {
    	$strings = array();
    	$menuDoName = "menu.do.MenuDO";	
    	$menuDO = BizSystem::getObject($menuDoName,1);
    	$result = $menuDO->directFetch();
    	
    	for($i=0;$i<count($result);$i++){
    		foreach($result[$i] as $key=>$value){
    			if($this->isTranslatableAttr(strtoupper($key))){
    				$strings[strtoupper($result[$i]["name"])."_".strtoupper($key)]=$value;
    			}
    		}
    	}
    	return $this->mergeStrings($strings);
    }

    private function getStringsFromACL()
    {
    	$strings = array();
    	$ACLDoName = "system.do.AclActionDO";	
    	$ACLDO = BizSystem::getObject($ACLDoName,1);
    	$result = $ACLDO->directFetch();
    	
    	for($i=0;$i<count($result);$i++){
    		foreach($result[$i] as $key=>$value){
    			if($this->isTranslatableAttr(strtoupper($key))){
    				$strings[strtoupper($result[$i]["module"])."_".$result[$i]["resource"]."_".strtoupper($key)]=$value;
    			}
    		}
    	}
    	return $this->mergeStrings($strings);
    }    
    
    private function getStringsFromSystem()
    {
    	$strings = array();
    	$dir = APP_HOME.DIRECTORY_SEPARATOR."messages";
    	$strings["MESSAGE"] = $this->getStringsFromMsg("SYSTEM",$dir);
    	
    	// scan message from openbiz message folder
    	$obStrings = $this->getMsgsFromOpenbiz();
    	$strings["MESSAGE"] = array_merge($strings["MESSAGE"],$obStrings);
    	
    	$dir = APP_HOME.DIRECTORY_SEPARATOR."themes";
    	$strings["TEMPLATES"] = $this->getStringsFromTemplate("SYSTEM",$dir);
    	return $strings;
    }
    
	private function getMsgsFromOpenbiz()
	{
		$messageDir = OPENBIZ_HOME.DIRECTORY_SEPARATOR."messages";
		$filelist = $this->getFileList($messageDir,".msg"); 
    	$strings=array(); 
    	foreach($filelist as $file){
    		if(CLI){
				echo "   Analyst Message File: ".str_replace(OPENBIZ_HOME.DIRECTORY_SEPARATOR,"",$file)." ".PHP_EOL;
			}
			$content = @file_get_contents($file);	
    		if (empty($content)) {			
				continue;
			}
			$matchs = array();			
			preg_match_all("/define\(.*?[\'\"]{1}(.*?)[\'\"]{1},.*?[\'\"]{1}(.*?)[\'\"]{1}\)/",
							$content,
							$matches
							);
			//print_r($matches);			
			for($i=0; $i<count($matches[1]); $i++) {
				$strings[$matches[1][$i]] = $matches[2][$i];
			}
			//print_r($strings);
    	}
    	return $this->mergeStrings($strings);
	}
    
	private function getFileList($dir,$fileext=".*")
	{
		$xmlFiles = array();
		if (!file_exists($dir))
			return array();
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		$i=0;
		foreach ($iterator as $file) {
			if(preg_match("/$fileext$/si",$file->getFilename())){
			    $xmlFiles[$i]=$file->getRealPath();
			    $i++;
			}
		}
		return $xmlFiles;
	}    
     
}

?>
