<?php
include_once 'BaseExtractor.php';

class FlatFileParser extends BaseExtractor 
{
	public $source;
	public $regexp;
	
	protected $fileHandle;

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);

		// take additional attributes
		$this->regexp = isset($xmlArr["ATTRIBUTES"]["REGEXP"]) ? $xmlArr["ATTRIBUTES"]["REGEXP"] : null;
    }
    
	public function openSource()
	{
		$this->fileHandle = fopen($this->source, 'r');
		if (!$this->fileHandle) {
			throw new Exception("Unable to open $this->source"); 
		}
	}
	
	public function closeSource()
	{
		fclose($this->fileHandle);
	}
   
	public function readRow()
	{
		$line = fgets($this->fileHandle);
		return $line;
	}

	public function extractRow()
	{
		$fieldList = array();
        
        $line = $this->readRow();

		// apply regexp to the line
		
        // validate each field
		
		return $fieldList;
    }
	
	public function getField($fieldName)
	{
	
	}
	
	protected function validateField($fieldName)
	{
	
	}
}

?>