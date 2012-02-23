<?php
include_once 'BaseExtracter.php';

class AccessLogParser extends BaseExtracter 
{
	public $source;
	public $regexp; // /^(\S+) \S+ \S+ \[([^\]]+)\] "([A-Z]+)[^"]*" \d+ \d+ "[^"]*" "([^"]*)"$/m
	
	protected $fileHandle;
	
	protected $_monthslookup = array('Jan'=>'01','Feb'=>'02','Mar'=>'03','Apr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'08','Sep'=>'09','Oct'=>'10','Nov'=>'11','Dec'=>'12');

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
		$keyVals = array();
		$line = $this->readRow();
		if ($line === false) return false;

		// apply regexp to the line
		if (!preg_match($this->regexp, $line, $matches)) {
			return;
		}
		
        $i = 1;
		foreach ($this->fieldList as $fld) {
            $fld->value = $matches[$i];
            $keyVals[$fld->m_Name] = $fld->value;
            $i++;
            if (!isset($matches[$i])) break;
		}
		
		try {
			$err = $this->validateRow($keyVals);
		}
		catch (ValidationException $e) { 
			echo $e->getMessage();
		}
		
		return $keyVals;
    }
	
	protected function getMonth($monthStr)
	{
		return $this->_monthslookup[$monthStr];
	}
}

?>