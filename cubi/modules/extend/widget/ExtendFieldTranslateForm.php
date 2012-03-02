<?php 
class ExtendFieldTranslateForm extends PickerForm
{

	protected $m_TranslateDO = "extend.do.ExtendSettingTranslationDO";
		
	
	public function fetchData()
	{
		
		$this->m_ActiveRecord = null;
		$result = parent::fetchData();
		
		$lang = BizSystem::ClientProxy()->getFormInputs("fld_lang");;
		$lang?$lang:$lang=I18n::getCurrentLangCode();
		$setting_id = $result["Id"];
		
		$transDO = BizSystem::getObject($this->m_TranslateDO,1);
		$currentRecord = $transDO->fetchOne("[setting_id]='$setting_id' AND [lang]='$lang'");
		if($currentRecord){
			$currentRecord = $currentRecord->toArray();
			foreach($currentRecord as $field => $value)
			{
				$result['_'.$field]=$value;
			}			
		}else{
			$result['_label'] = "";
			$result['_options'] = "";
			$result['_description'] = "";
			$result['_defaultvalue'] = "";
		}	
		return $result;
	}
	
	public function updateRecord()
	{
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) != 0){
            	
	        try
	        {
	            $this->ValidateForm();
	        }
	        catch (ValidationException $e)
	        {
	            $this->processFormObjError($e->m_Errors);
	            return;
	        }
	
	        if ($this->_doUpdate($recArr, $currentRec) == false)
	            return;
        
        }
		
		$this->m_Notices[]=$this->getMessage("TRANS_SAVED_MSG", $recArr['lang']) ;        
		$this->rerender();
	}
	
	protected function _doUpdate($inputRecord, $currentRecord)
    {
		
		$lang = $inputRecord['lang'];
		$setting_id = $currentRecord["Id"];		
		$transDO = BizSystem::getObject($this->m_TranslateDO,1);
		
		$newRecord = array(
						"setting_id"=>$setting_id,
						"lang"=>$lang,
						);
		foreach($inputRecord as $field=>$value)
		{
			if(substr($field,0,1)=='_')
			{
				$newRecord[substr($field,1,strlen($field)-1)] = $value;
			}
		}
		
		$currentRecord = $transDO->fetchOne("[setting_id]='$setting_id' AND [lang]='$lang'");
		if($currentRecord){
			$currentRecord = $currentRecord->toArray();
		}
		
		
        $dataRec = new DataRecord($currentRecord, $transDO);

        foreach ($newRecord as $k => $v){
           	$dataRec[$k] = $v; // or $dataRec->$k = $v;
        }

        BizSystem::getObject("extend.widget.ExtendSettingDetailForm",1)->processOptions($inputRecord['_options'], $setting_id, $lang);
        
        try
        {
            $dataRec->save();
        }
        catch (ValidationException $e)
        {
            $errElements = $this->getErrorElements($e->m_Errors);           
        	if(count($e->m_Errors)==count($errElements)){
            	$this->processFormObjError($errElements);
            }else{            	
            	$errmsg = implode("<br />",$e->m_Errors);
		        BizSystem::clientProxy()->showErrorMessage($errmsg);
            }
            return false;
        }
        catch (BDOException $e)
        {
            $this->processBDOException($e);
            return false;
        }
		$this->m_ActiveRecord = null;
        $this->getActiveRecord($dataRec["Id"]);

        $this->runEventLog();
        return true;
    }
    
}
?>