<?php

class PivotConfig
{
    public $columnFields = array();
    
    public $rowFields = array();
    
    public $dataFields = array();
    
    public $filterFields = array();
    
    public $queryLimit = 1000;
    
    public function addColumnField($colFld) { if ($colFld) $this->columnFields[] = $colFld; }
    
    public function addRowField($rowFld) { if ($rowFld) $this->rowFields[] = $rowFld; }
    
    public function addDataField($dataFld, $func) { if ($dataFld) $this->dataFields[] = array($dataFld, $func='SUM'); }
    
    public function addFilterField($filterFld) { if ($filterFld) $this->filterFields[] = $filterFld; }
}
?>