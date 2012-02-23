<?php
include_once 'ETLField.php';

class BaseTransformer extends MetaObject 
{
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

		$this->fieldList = new MetaIterator($xmlArr["FIELD"],"etl.lib.ETLField_Transform",$this);
    }
	
	public function getProperty($propertyName)
    {
		//echo "get property of $propertyName\n";
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
    
    public function transformRow($rowData)
	{
		// foreach field, do the transform function
		foreach ($this->fieldList as $fld) {
			$value = $fld->transform();
			$rowData[$fld->m_Name] = $value;
		}
		return $rowData;
    }
	
	public function getField($fieldName)
	{
		$fld = $this->fieldList->get($fieldName);
		if ($fld) return $fld;
		return $this->task->extract->fieldList->get($fieldName);
	}

}

?>