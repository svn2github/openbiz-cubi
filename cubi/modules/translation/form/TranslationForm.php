<?php 
include_once MODULE_PATH."/translation/lib/LangPackCreator.php";

class TranslationForm extends EasyForm
{
 public $m_Lang;

 public function getSessionVars($sessionContext)
    {
        parent::getSessionVars($sessionContext);
    	$sessionContext->getObjVar("Translation", "Lang", $this->m_Lang);
        
    }

    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar("Translation", "Lang", $this->m_Lang);      
    }	

        
    public function fetchData(){
    	preg_match("/\[([\S]*?)\]=\'file_(.*?)\'/si",$this->m_FixSearchRule,$match);
    	$Id = $match[2];
    	$resultArr = $this->fetchDataSet();
    	$record = $resultArr[$Id];
    	
    	require_once('Zend/Locale.php');
		$locale = new Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('language',$locale);
		$lang_code = $this->getLang();
    	$locale = explode('_', $lang_code);
		$lang = $code2name[$locale[0]];
    	$image_path = APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
    	$image = "<image  style=\"float:left;display:block;margin-right:5px;padding-top:2px;\" src=\"$image_path\" />";
		$record['lang']	=	"<div>".$image." <span style=\"float:left;display:block;\">$lang ( $lang_code )</span></div>";
    	$record['translation'] = file_get_contents($record['path']);
    	$this->m_RecordId = "file_".$Id;
    	return $record;
    }
    
	public function fetchDataSet(){
		$result = array();
		$lang = $this->getLang();
		$this->m_Lang = $this->getLang();
		$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;						
		if(!is_dir($lang_dir))
		{
			return 	$result;
		}
		$i=0;
		foreach (glob($lang_dir.DIRECTORY_SEPARATOR."*") as $dir){
			$filename = str_replace($lang_dir.DIRECTORY_SEPARATOR,"",$dir);
			if(strpos($filename,".ini") ){
				preg_match("/mod\.(.*?)\.ini/si",$filename,$match);
				if($match[1])
				{
					$module = ucfirst($match[1]);	
				}
				else
				{
					preg_match("/(.*?)\.ini/si",$filename,$match);
					$module = "General ".ucfirst($match[1]);	
				}
				
				$result[$i]["Id"] = "file_".$i;
				$result[$i]["name"] = $module;
				$result[$i]["filename"] = $filename;
				$result[$i]["path"] = $dir;
				$result[$i]["strings"] = (string)$this->countStrings($dir);
				$result[$i]["modification"] = date("Y-m-d H:i:s",filemtime($dir));
				$i++;
			}
		}
		if(!$this->m_RecordId){
			$this->m_RecordId=$result[0]["Id"];
		}
		return $result ; 
	}
	

	public function Update(){
		$currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        if (count($recArr) == 0)
            return;
        
        $record = $this->fetchData();
        $filename = $record["path"];
		$translation = $recArr["translation"];            
        file_put_contents($filename,$translation);

        $this->processPostAction();		
	}
	
	public function Delete(){
		if ($this->m_Resource != "" && !$this->allowAccess($this->m_Resource.".delete"))
            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
            
        $resultArr = $this->fetchDataSet();
        
        foreach ($selIds as $id)
        {
        	$id= str_replace("file_","",$id);
        	$filename = $resultArr[$id]["path"];
        	@unlink($filename);
        }
        if ($this->m_FormType == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
	}
	
	public function Reload()
	{
		$lang = $this->getLang();		
        $creator = new LangPackCreator($lang);
		$creator->createNew();
		return $this->UpdateForm();
	}
	
	private function getLang(){
		if($this->m_Lang){
			$lang = $this->m_Lang;
		}
		elseif($_GET['lang']){
			$lang = $_GET['lang'];
		}
		else
		{
			$lang = DEFAULT_LANGUAGE;	
		}
		return $lang;
	}
	
	public function updateLang(){
		$lang=BizSystem::clientProxy()->getFormInputs("selector_lang");
		$this->m_Lang=$lang;
		return $this->UpdateForm();
	}
	
	private function countStrings($file){
		$strArr = parse_ini_file($file,1);
		$count = 0;
		foreach($strArr as $section=>$arr){
			$count += count($arr);
		}
		return (int)$count;
	}
}
?>
