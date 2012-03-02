<?php 
class ExtendDataEditForm extends EasyForm
{
	protected $m_ExtendSettingDO 			= "extend.do.ExtendSettingDO";
	protected $m_ExtendSettingTranslationDO = "extend.do.ExtendSettingTranslationDO";
	protected $m_ExtendSettingOptionDO 		= "extend.do.ExtendSettingOptionDO";
	
	public function getExtendData()
	{
		$prtRec = BizSystem::getObject($this->m_ParentFormName)->getActiveRecord();		
		$record_id = (int)$prtRec['Id'];		
		$do = $this->getDataObj();
		$rec = $do->fetchOne("[record_id]='$record_id'");
		if($rec){
			$recArr = $rec->toArray();
		}else{
			$recArr = array();
		}
		return $recArr;
	}
	
	public function translateElemArr($elemArr,$setting_id)
	{
		$lang = I18n::getCurrentLangCode();

		if(!$lang){
			return $elemArr;
		}
		$setting_id = (int)$setting_id;
		
		$transDO = BizSystem::getObject($this->m_ExtendSettingTranslationDO,1);
		$transRec = $transDO->fetchOne("[setting_id]='$setting_id'");
		if(!$transRec)
		{
			return $elemArr;
		}
		$elemArr['LABEL']		 = $transRec['label'];
		$elemArr['DESCRIPTION']	 = $transRec['description'];
		$elemArr['DEFAULTVALUE'] = $transRec['defaultvalue'];
		if($elemArr['SELECTFROM'])
		{
			$transOptDO = BizSystem::getObject($this->m_ExtendSettingOptionDO,1);
			$opts = $transOptDO->directfetch("[setting_id]='".$setting_id."' AND [lang]='$lang'");			
			if($opts && $opts->count()>0){
				$elemArr['SELECTFROM'] = $this->m_ExtendSettingOptionDO."[text:value],[setting_id]='".$setting_id."' AND [lang]='$lang' ";				
			}
		}
		return $elemArr;
	}
	
	public function render()
	{
				
		$do = $this->getDataObj();
		$cond_column	= $do->m_Association['CondColumn'];
		$cond_value		= $do->m_Association['CondValue'];
		$column_name	= $do->m_Association['Column'];
		$column_value	= $do->m_Association['FieldRefVal']; 
		$searchRule = "`$cond_column` = '$cond_value' AND `$column_name`='$column_value'";
		
		$fieldsDO = BizSystem::getObject($this->m_ExtendSettingDO,1);
		$fieldRecs = $fieldsDO->directfetch($searchRule);
		
		if(!$fieldRecs->count()){
			return ;
		}
		
		$extData = $this->getExtendData();
		$i=0;
		foreach ($fieldRecs as $field){
			$elemArr = array(
				"NAME" 			=> "extend_field_".$field['Id'],
				"CLASS" 		=>	$field['class'],
				"LABEL" 		=>	$field['label'],
				"FIELDNAME"		=>	$field['field'],
				"ACCESS" 		=>	$field['access'],
				"DESCRIPTION"	=>	$field['description'],
				"DEFAULTVALUE"	=>	$field['defaultvalue'],				
			);
			
			if($field['options']){
				$elemArr['SELECTFROM']= $this->m_ExtendSettingOptionDO."[text:value],[setting_id]='".$field['Id']."' AND [lang]='' ";
			}
			
			$elemArr = $this->translateElemArr($elemArr,$field['Id']);

			$fieldArr = array(
				"ATTRIBUTES" 	=>	$elemArr,
				"VALUE"			=>	$extData[$field['field']]
			);
			$xmlArr[$i] = $fieldArr;
			$i++;
		}
		if(!$this->m_DataPanel->count())
		{
			if(count($xmlArr)==1){
				$xmlArr=$xmlArr[0];
			}
			$this->m_DataPanel = new Panel($xmlArr,"",$this);
		}
		return parent::render();
	}
}
?>