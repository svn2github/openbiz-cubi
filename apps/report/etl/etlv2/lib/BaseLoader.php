<?php
include_once 'ETLField.php';

class BaseLoader extends MetaObject 
{
	public $target;
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

		$this->target = isset($xmlArr["ATTRIBUTES"]["TARGET"]) ? $xmlArr["ATTRIBUTES"]["TARGET"] : null;
		// todo: apply expression on source
		
		$this->fieldList = new MetaIterator($xmlArr["FIELD"],"etl.lib.ETLField_Load",$this);
    }
	
	public function openTarget()
	{
	
	}
	
	public function closeTarget()
	{
	
	}
    
	// inject data into target (file, table, ...)
    public function loadRow($rowData)
	{
		
    }

}

?>