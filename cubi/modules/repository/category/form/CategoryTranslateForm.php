<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.extend.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ExtendFieldTranslateForm.php 3360 2012-05-31 06:00:17Z rockyswen@gmail.com $
 */

class CategoryTranslateForm extends PickerForm
{

	protected $m_TranslateDO = "repository.category.do.CategoryTranslateDO";
	protected $m_RecordFKField = "repo_cat_id";
	
	
	public function fetchData()
	{
		
		$this->m_ActiveRecord = null;
		$result = parent::fetchData();
		
		$lang = BizSystem::ClientProxy()->getFormInputs("fld_lang");
		$lang?$lang:$lang=I18n::getCurrentLangCode();
		$record_id = $result["Id"];
		
		$transDO = BizSystem::getObject($this->m_TranslateDO,1);
		$currentRecord = $transDO->fetchOne("[{$this->m_RecordFKField}]='$record_id' AND [lang]='$lang'");
		if($currentRecord){
			$currentRecord = $currentRecord->toArray();
			foreach($currentRecord as $field => $value)
			{
				$result['_'.$field]=$value;
			}			
		}else{
			$result['_name'] = "";
			$result['_description'] = "";
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
		$record_id = $currentRecord["Id"];		
		$transDO = BizSystem::getObject($this->m_TranslateDO,1);
		
		$newRecord = array(
    					"{$this->m_RecordFKField}" =>$record_id,
						"lang"=>$lang,
						);
		foreach($inputRecord as $field=>$value)
		{
			if(substr($field,0,1)=='_')
			{
				$newRecord[substr($field,1,strlen($field)-1)] = $value;
			}
		}
		
		$searchRule = "[{$this->m_RecordFKField}]='$record_id' AND [lang]='$lang'";
		$currentRecord = $transDO->fetchOne($searchRule);
		if($currentRecord){
			$currentRecord = $currentRecord->toArray();
		}
		
		
        $dataRec = new DataRecord($currentRecord, $transDO);

        foreach ($newRecord as $k => $v){
           	$dataRec[$k] = $v; // or $dataRec->$k = $v;
        }
        try
        {
			//test dump data
        	//var_dump($currentRecord);
        	//var_dump($dataRec->toArray());exit;
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