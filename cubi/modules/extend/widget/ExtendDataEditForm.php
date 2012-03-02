<?php 
class ExtendDataEditForm extends EasyForm
{
	protected $m_ExtendSettingDO = "extend.do.ExtendSettingDO";
	
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
				$elemArr['SELECTFROM']= "extend.do.ExtendSettingOptionDO[text:Value],[setting_id]='".$field['Id']."' AND lang='' ";
			}
			
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