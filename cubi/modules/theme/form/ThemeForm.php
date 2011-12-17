<?php 
include_once MODULE_PATH."/theme/lib/ThemeCreator.php";


class ThemeForm extends EasyForm
{

	public $theme;
	
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
        $this->ReadThemePack($recId,$rec);
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
	        $theme = $recArr['theme'];
	        $this->m_ValidateErrors = array();
	        if(is_dir(THEME_PATH.DIRECTORY_SEPARATOR.$theme)){	        			       	
	        		$errorMessage = $this->getMessage("FORM_THEME_EXIST",array("fld_theme"));
	                $this->m_ValidateErrors["fld_theme"] = $errorMessage;
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

        $this->CreateThemePack($theme , $recArr);
        

        $this->processPostAction();		
	}
	
	public function UpdateRecord()
	{
		$recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
		
        preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$theme = $match[2];		
        $this->UpdateThemePack($theme , $recArr);
        

        $this->processPostAction();		
	}

	public function Reload($id=null){
		if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
        if($id!='default'){
			$creator = new ThemePackCreator($id);
			$creator->createNew();
        }
		return ;
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
       		if(strtolower($id)=="default"){
        		BizSystem::clientProxy()->showClientAlert($this->getMessage("UNABLE_TO_DELETE_DEFAULT_PACK"));
            	$this->updateForm();
        		return;
        	}
        	else
        	{
        		$this->DeleteThemePack($id);
        	}            
        }
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }
    	
	public function fetchData(){
		if ($this->m_FormType == "NEW")
            return $this->getNewTheme();
                        
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$theme = $match[2];
		$dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
		$result['Id']	=	$theme;
		$result['name']	=	$theme;	
		$result['path']	=	$dir;				
		$result['default']	=	$this->isDefaultTheme($theme);		
		$result['current']	=	$this->isCurrentTheme(basename($dir));
		$result['users']	=	"0";
		
		$this->ReadThemePack($theme,$result);
		$this->m_RecordId = $theme;
		return $result;
	}
	
	public function fetchDataSet(){
		$result = array();
		$i = 0;
		foreach (glob(THEME_PATH.DIRECTORY_SEPARATOR."*",GLOB_ONLYDIR) as $dir){
			if(basename($dir)!='tmp'){
				$locale = explode('_', basename($dir));

				$result[$i]['Id']	=	basename($dir);
				$result[$i]['name']	=	basename($dir);	
				$result[$i]['path']	=	$dir;				
				$result[$i]['default']	=	$this->isDefaultTheme(basename($dir));
				$result[$i]['current']	=	$this->isCurrentTheme(basename($dir));
				$this->ReadThemePack(basename($dir),$result[$i]);

				$i++;	
			}
		}
		if(!$this->m_RecordId){
			$this->m_RecordId=$result[0]["Id"];
		}
		return $result;
	}

	
	public function isDefaultTheme($theme){
		if($theme == DEFAULT_THEME_NAME){
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isCurrentTheme($theme){
		if($theme == THEME_NAME){
			return true;
		}
		else
		{
			return false;
		}
	}	
	
    protected function getNewTheme()
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


	

	
	public function CreateThemePack($theme,$recArr){
		$this->m_RecordID=$theme;
		
		//mkdir
		$theme_dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
		@mkdir($theme_dir);
		
		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create theme.xml metainfo
		$smarty = BizSystem::getSmartyTemplate();
		$smarty->assign("theme_name", 		$recArr['name']);
		$smarty->assign("preview", 			$recArr['preview']);
		$smarty->assign("icon", 			$recArr['icon']);
		$smarty->assign("version", 			$recArr['version']);		
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(BizSystem::getTplFileWithPath("theme.xml.tpl", $this->m_Package));
		$theme_dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
		$theme_file = $theme_dir.DIRECTORY_SEPARATOR."theme.xml";
		file_put_contents($theme_file ,$data);
				
		
		//generate theme string files.		
		$creator = new ThemePackCreator($theme);
		$creator->createNew();
		return true;		
	}
	
public function UpdateThemePack($theme,$recArr){
		$this->m_RecordID=$theme;
		$locale = explode('_', $theme);
	    $theme_code = strtolower($locale[0]);

		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create theme.xml metainfo
		$smarty = BizSystem::getSmartyTemplate();
		$smarty->assign("theme_name", 		$recArr['name']);
		$smarty->assign("preview", 			$recArr['preview']);
		$smarty->assign("icon", 			$recArr['icon']);
		$smarty->assign("version", 			$recArr['version']);		
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(BizSystem::getTplFileWithPath("theme.xml.tpl", $this->m_Package));
		$theme_dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
		$theme_file = $theme_dir.DIRECTORY_SEPARATOR."theme.xml";
		@unlink($theme_file);
		file_put_contents($theme_file ,$data);
		
		
		//generate theme string files.
		
		return true;		
	}
	
	public function ReadThemePack($theme,&$recArr=array()){		
		$theme_dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
		$theme_metafile = $theme_dir.DIRECTORY_SEPARATOR."theme.xml";
		if(is_file($theme_metafile)){
			$metadata = file_get_contents($theme_metafile);
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
		if(is_file(THEME_PATH.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$recArr['icon']))
		{
			$recArr['icon_url'] = THEME_URL."/$theme/images/".$recArr['icon'];
		}
		else
		{
			$recArr['icon_url'] =THEME_URL."/$theme/images/spacer.gif";
		}
		if(is_file(THEME_PATH.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$recArr['preview']))
		{
			$recArr['preview_url'] = THEME_URL."/$theme/images/".$recArr['preview'];
			return $recArr;		
		}
		else
		{
			$recArr['preview_url'] =THEME_URL."/$theme/images/spacer.gif";
		}
	}

	public function DeleteThemePack($theme){		
		$dir = THEME_PATH.DIRECTORY_SEPARATOR.$theme;
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
