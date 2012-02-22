<?php
include_once 'ETLField.php';

class BaseTransformer extends MetaObject 
{

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);

		// take additional attributes
    }
    
    public function transformRow($rowData)
	{
		return $rowData;
    }
	
	protected function transformField($fieldObj)
	{
		
    }
	
	public function getField($fieldName)
	{
	
	}

}

?>