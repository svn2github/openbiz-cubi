<?php
include_once 'ETLField.php';

class BaseLoader extends MetaObject 
{
	public $target;
	public $fieldList;
	
    function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->m_parentObj = $parentObj;
    }

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);

		$this->target = isset($xmlArr["ATTRIBUTES"]["TARGET"]) ? $xmlArr["ATTRIBUTES"]["TARGET"] : null;
		// todo: apply expression on source
		
		$this->fieldList = new MetaIterator($xmlArr["FIELD"],"ETLField",$this);
    }
	
	public function openTarget()
	{
	
	}
	
	public function closeTarget()
	{
	
	}
    
    public function loadRow($rowData)
	{
        // write the row data into target
        
    }

}

?>