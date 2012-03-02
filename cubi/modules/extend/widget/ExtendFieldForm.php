<?php 
class ExtendFieldForm extends PickerForm
{
	protected $m_SettingOptionDO = "extend.do.ExtendSettingOptionDO";
 	
	protected function _doUpdate($inputRecord, $currentRecord)
    {
    	$this->processOptions($inputRecord['options'], $currentRecord['Id']);
    	return parent::_doUpdate($inputRecord, $currentRecord);
    }
	
    
    protected function _doInsert($inputRecord)
    {
    	$recordId = parent::_doInsert($inputRecord);
    	$this->processOptions($inputRecord['options'], $recordId);
    	return $recordId;
    }
    
    public function processOptions($option_str,$setting_id,$lang=null)
    {
    	$optDO = BizSystem::getObject($this->m_SettingOptionDO);
    	$optionArr = explode(";", $option_str);
    	$i=1;
    	$setting_id = (int)$setting_id;
    	$optDO->deleteRecords("[setting_id]='$setting_id' AND lang='$lang'");
    	foreach ($optionArr as $option)
    	{
    		$optRec = array(
    			"setting_id" => (int)$setting_id,
    			"lang" => $lang,
    			"text" => $option,
    			"value" => $i
    		);
    		$optDO->insertRecord($optRec);
    		$i++;
    	}
    } 	
}
?>