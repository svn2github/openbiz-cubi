<?php 
include_once MODULE_PATH."/translation/lib/LangPackCreator.php";


class LanguageForm extends EasyForm
{
	public $m_Lang_Region;
	public $m_Lang_Icon;

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
		$rec=array();
        $this->ReadLangPack($recId,$rec);
        $this->m_DataPanel->setRecordArr($rec);
        $this->m_ActiveRecord = $rec;
        return $rec;
    }
	
	public function InsertRecord()
	{
        $recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
                           
            
        try
        {
	        $lang = $recArr['lang'];
	        $this->m_ValidateErrors = array();
	        if(is_dir(APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang)){	        			       	
	        		$errorMessage = $this->getMessage("FORM_LANG_EXIST",array("fld_lang"));
	                $this->m_ValidateErrors["fld_lang"] = $errorMessage;
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

        $this->CreateLangPack($lang , $recArr);
        

        $this->processPostAction();		
	}
	
	public function UpdateRecord()
	{
		$recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
		
        preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$lang = $match[2];		
        $this->UpdateLangPack($lang , $recArr);
        

        $this->processPostAction();		
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
        foreach ($selIds as $id)
        {
            $this->DeleteLangPack($id);            
        }
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }
    	
	public function fetchData(){
		if ($this->m_FormType == "NEW")
            return $this->getNewLang();
                        
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$lang = $match[2];
		$dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$locale = explode('_', $lang);
		$result['Id']	=	$lang;
		$result['name']	=	$lang;	
		$result['lang']	=	$lang;			
		$result['path']	=	$dir;				
		$result['code']	=	$lang;
		$result['default']	=	$this->isDefaultLang($lang);		
		$result['users']	=	"0";
		
		$this->ReadLangPack($lang,$result);
		if($locale[1]){
			$result['language']	=	$this->Code2Language($locale[0]);
			$result['region']	=	$this->Code2Region($locale[1]);
			$result['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
			
		}
		else
		{
			$result['language']	=	$this->Code2Language($locale[0]);
			$result['region']	=	$this->Code2Region($locale[0]);
			$result['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
			
		}		
		$this->m_RecordId = $lang;
		return $result;
	}
	
	public function fetchDataSet(){
		$result = array();
		$i = 0;
		foreach (glob(APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR."*",GLOB_ONLYDIR) as $dir){
			if(basename($dir)!='tmp' && basename($dir)!='dictionary'){
				$locale = explode('_', basename($dir));

				$result[$i]['Id']	=	basename($dir);
				$result[$i]['name']	=	basename($dir);	
				$result[$i]['path']	=	$dir;				
				$result[$i]['code']	=	basename($dir);
				$result[$i]['default']	=	$this->isDefaultLang(basename($dir));
				$result[$i]['users']	=	"0";
				$this->ReadLangPack(basename($dir),$result[$i]);
				
				if($locale[1]){
					$result[$i]['lang']	=	$this->Code2Language($locale[0]);
					$result[$i]['region']	=	$this->Code2Region($locale[1]);
					$result[$i]['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
					
				}
				else
				{
					$result[$i]['lang']	=	$this->Code2Language($locale[0]);
					$result[$i]['region']	=	$this->Code2Region($locale[0]);
					$result[$i]['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
				}
				$i++;	
			}
		}
		if(!$this->m_RecordId){
			$this->m_RecordId=$result[0]["Id"];
		}
		return $result;
	}

	public function Code2Name($code){
		$result = $this->Code2Region($code, 'en_US' );
		return $result;
	}
	
	public function isDefaultLang($lang){
		if($lang == DEFAULT_LANGUAGE){
			return true;
		}
		else
		{
			return false;
		}
	}

    protected function getNewLang()
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
        $selected_lang = BizSystem::clientProxy()->getFormInputs("fld_region");
        if(!$selected_lang)
        {
			$selected_lang = "en_ad";
            $recArr['lang'] = "en_AG";	
        }else{
        	$country = $selected_lang; 	
	    	$country = strtoupper($country);  
	    	if(!$country){    		
	    		$locale = explode('_', $current_locale);
	    		$country = strtoupper($locale[0]);
	    	}  	
			require_once('Zend/Locale.php');
			$locale = new Zend_Locale($current_locale);
			$code2name = $locale->getTranslationList('territorytolanguage',$locale);
			$list = array();
			$i=0;
			foreach($code2name as $key => $value){	
				
				if(preg_match('/'.$country.'/',$value) || strtoupper($key)==$country){				
					$lang_list = explode(" ",$value);				
					foreach($lang_list as $lang){
						$list[$i]['txt'] = strtolower($key)."_".strtoupper($lang);
						$list[$i]['val'] = strtolower($key)."_".strtoupper($lang);
						$i++;
						break;break;
					}
				}
			}
			$recArr['lang'] = $list[0]['val'];	
        }
        $locale = explode('_', $selected_lang);
    	if($locale[1]){
			$recArr['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
    	}
		else
		{
			$recArr['icon']	=	APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
		}
		
		
        return $recArr;
    }	


	
	public function Code2Language($code,$locale=null){
		$code=strtolower($code);
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('language',$locale);
		$result = $code2name[$code];
		$locale = null;
		$code2name = null;
		return $result;
	}

	public function Code2Region($code,$locale=null){
		$code=strtoupper($code);
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('territory',$locale);
		$result = $code2name[$code];
		$locale = null;
		$code2name = null;
		return $result;
	}
	
	public function CreateLangPack($lang,$recArr){
		$this->m_RecordID=$lang;
		$locale = explode('_', $lang);
	    $lang_code = strtolower($locale[0]);
		
		//mkdir
		$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		@mkdir($lang_dir);
		
		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create lang.xml metainfo
		$smarty = BizSystem::getSmartyTemplate();
		$smarty->assign("language", 		$this->Code2Language($lang_code));
		$smarty->assign("lang_code", 		$lang);
		$smarty->assign("version", 			$recArr['version']);
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(BizSystem::getTplFileWithPath("lang.xml.tpl", $this->m_Package));
		file_put_contents($lang_dir.DIRECTORY_SEPARATOR.$lang.".xml" ,$data);
		
		
		//generate lang string files.
		$creator = new LangPackCreator($lang);
		$creator->createNew();
		return true;		
	}
	
public function UpdateLangPack($lang,$recArr){
		$this->m_RecordID=$lang;
		$locale = explode('_', $lang);
	    $lang_code = strtolower($locale[0]);

		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create lang.xml metainfo
		$smarty = BizSystem::getSmartyTemplate();
		$smarty->assign("language", 		$this->Code2Language($lang_code));
		$smarty->assign("lang_code", 		$lang);
		$smarty->assign("version", 			$recArr['version']);
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(BizSystem::getTplFileWithPath("lang.xml.tpl", $this->m_Package));
		$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$lang_file = $lang_dir.DIRECTORY_SEPARATOR.$lang.".xml";
		@unlink($lang_file);
		file_put_contents($lang_file ,$data);
		
		
		//generate lang string files.
		
		return true;		
	}
	
	public function ReadLangPack($lang,&$recArr=array()){		
		$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$lang_metafile = $lang_dir.DIRECTORY_SEPARATOR.$lang.".xml";
		if(is_file($lang_metafile)){
			$metadata = file_get_contents($lang_metafile);
			$xmldata = new SimpleXMLElement($metadata);		
			foreach ($xmldata as $key=>$value){
				if(substr($key,0,1)!="@")
				{
					$str=(string)$value;
					$str=str_replace('\n',"\n",$str);
					$str=stripcslashes($str);
					$recArr[$key]=$str;
				}
			}
		}
		return $recArr;		
	}

	public function DeleteLangPack($lang){		
		$dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$iterator = new RecursiveDirectoryIterator($dir);
		   foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file)
		   {
			      if ($file->isDir()) {
			         @rmdir($file->getPathname());
			      } else {
			         @unlink($file->getPathname());
			      }
		   		
		   }
		   
		   	@rmdir($dir);	
	    	
		return true;		
	}
		
}
?>
