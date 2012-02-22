<?php

class ETLField extends MetaObject
{

}

class ETLField_Extract extends ETLField 
{
	public $key;
	public $required;
	public $validation;
	
	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		
		$this->key = isset($xmlArr["ATTRIBUTES"]["KEY"]) ? $xmlArr["ATTRIBUTES"]["KEY"] : null;
		$this->required = isset($xmlArr["ATTRIBUTES"]["REQUIRED"]) ? $xmlArr["ATTRIBUTES"]["REQUIRED"] : null;
		$this->validation = isset($xmlArr["ATTRIBUTES"]["VALIDATION"]) ? $xmlArr["ATTRIBUTES"]["VALIDATION"] : null;
	}
}

class ETLField_Transform extends ETLField 
{
	public $value;
	
	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		
		$this->value = isset($xmlArr["ATTRIBUTES"]["VALUE"]) ? $xmlArr["ATTRIBUTES"]["VALUE"] : null;
	}
}

class ETLField_Load extends ETLField 
{
	public $from;
	public $to;
	
	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		
		$this->from = isset($xmlArr["ATTRIBUTES"]["FROM"]) ? $xmlArr["ATTRIBUTES"]["FROM"] : null;
		$this->to = isset($xmlArr["ATTRIBUTES"]["TO"]) ? $xmlArr["ATTRIBUTES"]["TO"] : null;
	}
}
?>