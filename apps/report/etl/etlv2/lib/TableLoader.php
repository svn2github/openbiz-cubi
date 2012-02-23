<?php

include_once 'BaseLoader.php';

class TableLoader extends BaseLoader 
{
	public $dbName;
	public $tableName;
	
    protected function readMetadata(&$xmlArr)
    {
		parent::readMetaData($xmlArr);
		
		// take additional attributes
		list($this->dbName, $this->tableName) = explode(".", $this->target);
    }
	
	public function openTarget()
	{
	
	}
	
	public function closeTarget()
	{
	
	}
    
	// generate an insert sql
    public function loadRow($rowData)
	{
		// foreach field, get the value from 'from' for 'to' column
		$columnValues = array();
		foreach ($this->fieldList as $fld) {
			$columnValues[] = "'".$rowData[$fld->from]."'";
			$columnNames[] = "`".$fld->to."`";
		}
		
		// generate insert sql on target table
		$col_name_str = implode(",", $columnNames);
		$col_val_str = implode(",", $columnValues);
		$insertSql = "INSERT INTO ".$this->tableName." ($col_name_str) VALUES ($col_val_str)";
		
		echo "insert sql > $insertSql \n";
    }

}

?>