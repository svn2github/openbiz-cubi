<?php

class EtlTask extends MetaObject 
{  
	public $extract;
	public $transform;
	public $loadList;
	
	protected $m_Finished;
	protected $m_parentObj;
	
    function __construct(&$xmlArr, $parentObj)
    {
        $this->readMetadata($xmlArr);
        $this->m_parentObj = $parentObj;
    }

    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);
		
		// read extract section
		$this->extract = $this->getElementObject($xmlArr["EXTRACT"], "BaseExtractor", $this);
		
		// read transform section
		$this->transform = $this->getElementObject($xmlArr["TRANSFORM"], "BaseTransformer", $this);
		
		// read loadlist section
		$this->loadList = new MetaIterator($xmlArr["LOAD"], "BaseLoader", $this);
		
    }
    
    public function finished()
	{
    	return $this->m_Finished;
    }
    
    public function process()
	{
		try {
			$this->extract->openSource();
			foreach ($this->loadList as $load) {
				$load->openTarget();
			}
			while (1) {
				echo "--- Step 1: extract ---\n";
				$rowData = $this->extract->extractRow();
				if ($rowData === false) { break; }
				if ($rowData == null) continue;
                print_r($rowData);
				echo "--- Step 2: transform ---\n";
				$rowData = $this->transform->transformRow($rowData);
                print_r($rowData);
				foreach ($this->loadList as $load) {
					echo "--- Step 3: load ---\n";
					$load->loadRow($rowData);
				}
			}
			foreach ($this->loadList as $load) {
				$load->closeTarget();
			}
			$this->extract->closeSource();

			echo "[DONE]".PHP_EOL;
		}
		catch (Exception $e) {
			print_r($e);
			exit;
		}
    }
}
?>