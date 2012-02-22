<?php

include_once 'BaseLoader.php';

class TableLoader extends BaseLoader 
{

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);
		
		// take additional attributes
    }
	
	public function openTarget()
	{
	
	}
	
	public function closeTarget()
	{
	
	}
    
    public function loadRow()
	{

    }

}

?>