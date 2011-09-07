<?php
include_once "ReportForm.php";
class ReportListForm extends ReportForm
{
    protected $pivotCfg = null;
    
    // render pivot form
    public function setPivot($pivotConfig)
    {
        $this->pivotCfg = $pivotConfig;
        
        // set pivot DO with fields and otherSQL
    }
    
    public function fetchDataSet()
    {
        if (!$this->pivotCfg) return parent::fetchDataSet();
        
        $groupBy = $this->pivotCfg->columnFields[0];
        foreach ($this->pivotCfg->rowFields as $rf) {
            $groupBy .= $rf;
        }
        // set DO otherSQL
        
        foreach ($this->pivotCfg->dataFields as $df) {
            $queryDataFields .= $df[1]."(".$df[0].")";
        }
        // set DO fields
        
        // sql = select func1(df1), func2(df2) from table group by cf, rf1, rf2
        // override fetchDataSet(). e.g. N records found, has m distinct values of cf. 
        //    old matrix [N rows, 2 columns]
        //    new matrix [N/m rows, 2m columns]
    }
}
?>