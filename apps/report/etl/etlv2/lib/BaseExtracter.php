<?php
include_once 'ETLField.php';

class BaseExtracter extends MetaObject 
{
	public $source;
	public $fieldList;
	public $task;
	
    function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->task = $parentObj;
    }

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);

		$this->source = isset($xmlArr["ATTRIBUTES"]["SOURCE"]) ? $xmlArr["ATTRIBUTES"]["SOURCE"] : null;
		// todo: apply expression on source
		
		$this->fieldList = new MetaIterator($xmlArr["FIELD"],"etl.lib.ETLField_Extract",$this);
    }
	
	public function getProperty($propertyName)
    {
		$ret = parent::getProperty($propertyName);
        if ($ret !== null) return $ret;

        $pos1 = strpos($propertyName, "[");
        $pos2 = strpos($propertyName, "]");
        if ($pos1>0 && $pos2>$pos1)
        {
            $propType = substr($propertyName, 0, $pos1);
            $fieldName = substr($propertyName, $pos1+1,$pos2-$pos1-1);
			$result = $this->getField($fieldName);         
            return $result;
        }
    }
    
	public function openSource()
	{

	}
	
	public function closeSource()
	{

	}
   
	// read a row of data
	public function readRow()
	{
		
	}
	
	public function extractRow()
	{
		// read a row of data
		
		// set field values
		
		// validate the fields
		
    }
	
	protected function validateRow($rowData)
	{
		$validateErrors = array();
		// for each field
		foreach ($this->fieldList as $fld) {
			if (($result = $this->validateField($fld, $rowData)) !== true) {
				$validateErrors[$fld->m_Name] = $result;
			}
		}
		// throw validation exception on validation errors
		if (count($validateErrors) > 0)
        {
            throw new ValidationException($validateErrors);
            return false;
        }
	}
	
	public function getField($fieldName)
	{
		return $this->fieldList->get($fieldName);
	}
	
	protected function validateField($fld, $rowData)
	{
		// check required attribute
		//echo "validate field $fld->m_Name \n";
		if ($fld->required && empty($rowData[$fld->m_Name])) {
			$error = $fld->m_Name." cannot have empty data";
			return $error;
		}
		
		// check validator expression
		if ($fld->validator && !$fld->validate()) {
			$error = $fld->m_Name." cannot pass validation ".$fld->validator;
			return $error;
		}
		return true;
	}

}

?>