<?php
include_once 'ETLField.php';

class BaseExtractor extends MetaObject 
{
	public $source;
	public $fieldList;
	
    function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->m_parentObj = $parentObj;
    }

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);

		$this->source = isset($xmlArr["ATTRIBUTES"]["SOURCE"]) ? $xmlArr["ATTRIBUTES"]["SOURCE"] : null;
		// todo: apply expression on source
		
		$this->fieldList = new MetaIterator($xmlArr["FIELD"],"ETLField",$this);
    }
    
	public function openSource()
	{

	}
	
	public function closeSource()
	{

	}
   
	public function readRow()
	{
	
	}
	
	public function extractRow()
	{
		// read a row data
        
        // extract the row data into a field array
        
        // validate each field
        
        // return field array
        
    }
	
	public function getField($fieldName)
	{
	
	}
	
	protected function validateField($fieldName)
	{
	
	}
}

?>