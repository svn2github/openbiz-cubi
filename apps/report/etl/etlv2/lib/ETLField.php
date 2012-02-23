<?php

class ETLField extends MetaObject
{
	public $value;
	public $required;
	public $validator;
	protected $container;
	
	function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->container = $parentObj;
    }
	
	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		$this->value = isset($xmlArr["ATTRIBUTES"]["VALUE"]) ? $xmlArr["ATTRIBUTES"]["VALUE"] : null;
		$this->required = isset($xmlArr["ATTRIBUTES"]["REQUIRED"]) ? $xmlArr["ATTRIBUTES"]["REQUIRED"] : null;
		$this->validator = isset($xmlArr["ATTRIBUTES"]["VALIDATION"]) ? $xmlArr["ATTRIBUTES"]["VALIDATION"] : null;
		
		$this->required = ($this->required == "Y") ? true : false;
	}
	
	public function getProperty($propertyName)
    {
		if ($propertyName == "Value") return $this->value;
        $ret = parent::getProperty($propertyName);
        if ($ret) return $ret;
        return $this->$propertyName;
    }
	
	public function validate()
    {
        $ret = true;
        if ($this->validator)
            $ret = Expression::evaluateExpression($this->validator, $this->container);
        return $ret;
    }

}

class ETLField_Extract extends ETLField 
{
	public $key;

	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		
		$this->key = isset($xmlArr["ATTRIBUTES"]["KEY"]) ? $xmlArr["ATTRIBUTES"]["KEY"] : null;
	}
}

class ETLField_Transform extends ETLField 
{
	public $xfunc;

	protected function readMetaData(&$xmlArr)
	{
		parent::readMetaData($xmlArr);
		
		$this->xfunc = isset($xmlArr["ATTRIBUTES"]["FUNCTION"]) ? $xmlArr["ATTRIBUTES"]["FUNCTION"] : null;
	}
	
	public function transform()
	{
		$ret = "";
		if ($this->xfunc)
            $ret = Expression::evaluateExpression($this->xfunc, $this->container);
		$this->value = $ret;
        return $ret;
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