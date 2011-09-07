<?php

class PivotConfig
{
    public $columnFields;
    
    public $rowFields;
    
    public $dataFields;
    
    public $filterFields;
    
    public function addColumnField($colFld) { $this->columnFields[] = $colFld; }
    
    public function addRowField($rowFld) { $this->rowFields[] = $rowFld; }
    
    public function addDataField($dataFld, $func) { $this->dataFields[] = array($dataFld, $func='SUM'); }
    
    public function addFilterField($filterFld) { $this->filterFields[] = $filterFld; }
}
?>