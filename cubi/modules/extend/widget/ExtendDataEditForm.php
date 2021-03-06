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
 * @version   $Id$
 */

class ExtendDataEditForm extends EasyForm
{
	protected $m_ExtendSettingDO 			= "extend.do.ExtendSettingDO";
	protected $m_ExtendSettingTranslationDO = "extend.do.ExtendSettingTranslationDO";
	protected $m_ExtendSettingOptionDO 		= "extend.do.ExtendSettingOptionDO";
	

	
	public function getExtendData()
	{
		$prtRec = BizSystem::getObject($this->m_ParentFormName)->getActiveRecord();		
		$record_id = (int)$prtRec['Id'];		
		$do = BizSystem::getObject($this->getDataObj()->m_Name,1);
		$searchRule = $this->getSettingSearchRule();
		$do->clearSearchRule();
		if(!$searchRule){
			$searchRule = "TRUE ";
		}
		$rec = $do->directfetch($searchRule." AND [record_id]='$record_id'");
		if($rec[0]){
			$recArr = $rec[0];
		}else{
			$recArr = array();
		}
		return $recArr;
	}
	
	public function translateElemArr($elemArr,$setting_id)
	{		
		return BizSystem::getService("extend.lib.ExtendFieldService")->translateElemArr($elemArr,$setting_id);
	}
	
	public function getSettingSearchRule()
	{
		
		$do = $this->getDataObj();
		$cond_column	= $do->m_Association['CondColumn'];
		$cond_value		= $do->m_Association['CondValue'];
		$column_name	= $do->m_Association['Column'];
		$column_value	= $do->m_Association['FieldRefVal']; 
		
		if(!$column_name){
			return $this->m_SearchRule;
		}
		
		$prtFormObj = BizSystem::getObject($this->m_ParentFormName);
		$elem_name = $prtFormObj->m_DataPanel->getByField($column_name)->m_Name;		
		$type_id = BizSystem::ClientProxy()->getFormInputs($elem_name);
		if (!$type_id && $elem_name) {
			$type_id = $prtFormObj->getElement($elem_name)->getValue();
		}
		if($elem_name && $type_id)
		{
			$column_value = $type_id;
		}
		$searchRule = "[$cond_column] = '$cond_value' AND [$column_name]='$column_value'";
		$this->m_SearchRule = $searchRule;
		return $searchRule;	
	}
	
	public function fetchData()
	{
		return $this->getExtendData();
	}
	
	public function render()
	{						
		if(!$this->m_DataPanel->count())
		{		
			$this->m_DataPanel = new Panel($this->configDataPanel(),"",$this);
		}	
		if(!$this->m_DataPanel->count()){
			return "";
		}
		return parent::render();
	}
	
	public function configDataPanel($translate=true)
	{
		$searchRule = $this->getSettingSearchRule();
		$fieldsDO = BizSystem::getObject($this->m_ExtendSettingDO,1);
		$fieldRecs = $fieldsDO->directfetch($searchRule);
		
		if(!$fieldRecs->count()){
			return ;
		}
		
		$extData = $this->getExtendData();
		
		
		foreach ($fieldRecs as $field){
			$elemArr = array(
				"NAME" 			=> "extend_field_".$field['Id'],
				"CLASS" 		=>	$field['class'],
				"LABEL" 		=>	$field['label'],
				"FIELDNAME"		=>	$field['field'],
				"ACCESS" 		=>	$field['access'],
				"DESCRIPTION"	=>	$field['description'],
				"DEFAULTVALUE"	=>	$field['defaultvalue'],	
				"FIELDTYPE"		=>	'ExtendField',						
			);
			
			if($field['options']){
				$elemArr['SELECTFROM']= $this->m_ExtendSettingOptionDO."[text:value],[setting_id]='".$field['Id']."' AND [lang]='' ";
			}
			
			if($translate){
				$elemArr = $this->translateElemArr($elemArr,$field['Id']);
			}
			$fieldArr = array(
				"ATTRIBUTES" 	=>	$elemArr,
				"VALUE"			=>	$extData[$field['field']]
			);
			
			$fieldArr = $this->configElemArr($fieldArr);			
			if(BizSystem::allowUserAccess($elemArr['ACCESS'])){
				$xmlArr[] = $fieldArr;
			}
			
		}
		if(count($xmlArr)==1){
			$xmlArr=$xmlArr[0];
		}
		return $xmlArr;	
	}
	
	public function configElemArr($elemArr)
	{
		switch($elemArr['ATTRIBUTES']['CLASS'])
		{
			
			case "LabelBool":
				$elemArr['ATTRIBUTES']['CLASS']="DropDownList";
				$elemArr['ATTRIBUTES']['SELECTFROM']="common.lov.CommLOV(EnableStatus)";
				break;
		}		
		return $elemArr;
	}
	
	public function readInputExtendRecord()
	{		
		
		$searchRule = $this->m_SearchRule;
		$fieldsDO = BizSystem::getObject($this->m_ExtendSettingDO,1);
		$fieldRecs = $fieldsDO->directfetch($searchRule);
		
		if(!$fieldRecs->count()){
			return ;
		}
		
		$rec = array();
		foreach ($fieldRecs as $field){
			if(BizSystem::allowUserAccess($field['access'])){
				$elem_name = "extend_field_".$field['Id'];
				$field_name = $field['field'];
				$field_value = BizSystem::ClientProxy()->getFormInputs($elem_name);
				$rec[$field_name]=$field_value;
			}
		}
		return $rec;
	}
	
	public function setValue($value='') {	
		if(	strtolower($_GET['P1'])=='[updateform]' 
			|| strtolower($_GET['P1'])=='[switchform]'
			|| $_GET['P1']==''){
			return;
		}
		if(!$this->m_ParentFormName)
		{
			return ;
		}
		if($this->m_Saved)
		{
			return ;
		}
		
		$recArr = $this->readInputExtendRecord();
		$do = $this->getDataObj();
		
		$cond_column	= $do->m_Association['CondColumn'];
		$cond_value		= $do->m_Association['CondValue'];
		$column_name	= $do->m_Association['Column'];
		$column_value	= $do->m_Association['FieldRefVal']; 
				
		$elem_name = BizSystem::getObject($this->m_ParentFormName)->m_DataPanel->getByField($column_name)->m_Name;
		if($elem_name){
			$column_value = BizSystem::ClientProxy()->getFormInputs($elem_name);
		}
		$record_id = BizSystem::getObject($this->m_ParentFormName)->m_RecordId;
		
		$recArr[$cond_column] = $cond_value;
		$recArr[$column_name] = $column_value;
		$recArr['record_id'] = $record_id;				
		
		$oldRec = BizSystem::getObject($do->m_Name,1)->fetchOne($this->m_SearchRule." AND [record_id]='$record_id'" );
		if($oldRec){
			$oldRec = $oldRec->toArray();						
			$recArr['Id'] = $oldRec['Id'];
			$extendId = $this->getDataObj()->updateRecord($recArr,$oldRec);
		}else{		
			$extendId = $this->getDataObj()->insertRecord($recArr);			
		}
		$this->m_Saved = true;
		
		//if installed changelog then save change log
		
		if(BizSystem::getService("system.lib.ModuleService")->isModuleInstalled("changelog")){
			$formObj = BizSystem::getObject($this->m_ParentFormName);
			$panel = new Panel($this->configDataPanel($translate = false),"",$this);
			if(!is_array($oldRec)){
				$outputRecord = array();
			}else{
				$outputRecord = $oldRec;
			}			
			$inputRecord = $recArr;
			$inputRecord['Id'] = $outputRecord['Id'] = $record_id;
			foreach($inputRecord as $key=>$value)
			{
				if(!preg_match("/^field_/si",$key))
				{
					unset($inputRecord[$key]);
				}	
			}			
			foreach($outputRecord as $key=>$value)
			{
				if(!preg_match("/^field_/si",$key))
				{
					unset($outputRecord[$key]);
				}	
			}
			$outputRecord['Id'] = $record_id;			
			BizSystem::getService("changelog.lib.ChangeLogService")
						->LogDataChanges($formObj,$inputRecord,$outputRecord,null,$panel);
			
		}
		return true;
		
	}
	
	public function getValue()
	{
		return null;
	}
}
?>