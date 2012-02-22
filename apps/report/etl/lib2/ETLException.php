<?php
class ETLException extends Exception
{
    public $etlQueue;
    public $etlTask;    
    
    public function __construct($errorMessage, $code=0, $etlQueue=null, $etlTask=null)
    {
        parent::__construct($errorMessage, $code);
        $this->etlQueue = $etlQueue;
        $this->etlTask = $etlTask;
    }
}
?>