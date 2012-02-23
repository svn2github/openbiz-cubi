<?php
class ETLJob
{  
	public $m_Name;
	public $m_Tasks;
	
    function __construct(&$xmlArr,&$dbConnections)
    {
        $this->readMetadata($xmlArr,$dbConnections);
    }

    protected function readMetadata(&$xmlArr,&$dbConnections)
    {
    	$this->m_Name = trim($xmlArr["ATTRIBUTES"]["NAME"]) ;
        //init tasks
		$this->m_Tasks = new MetaIterator($xmlArr["TASK"],"ETLTask",$this);
    }
    
    public function process(){
	    if(defined("CLI")){
			echo "\nStart process job: ".$this->m_Name.PHP_EOL;						
		}
		
    	foreach ($this->m_Tasks as $taskName=>$task){
			if(defined("CLI")){
				echo "  [Running]".PHP_EOL;
			}
			$task->process();
    	}
    	if(defined("CLI")){
			echo "Finished process job: ".$this->m_Name." [DONE]".PHP_EOL.PHP_EOL;
		} 
    }

}
?>