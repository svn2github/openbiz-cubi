<?php 
include_once OPENBIZ_BIN."/easy/element/Listbox.php";
class FieldListbox extends Listbox
{
	
    public function getFromList(&$list, $selectFrom=null)
    {
        if (!$selectFrom) {
            $selectFrom = $this->getSelectFrom();
        }
        $this->getSimpleFromList($list, $selectFrom);
        if ($list != null)
            return;
        
        return;
    }	
    

	    
    
    protected function getSimpleFromList(&$list, $selectFrom)
    {		
        $db = $this->getFormObj()->getViewObject()->getDBConn();
        $tableName = $this->getFormObj()->getViewObject()->getTableName();
        $sql = "SHOW FULL COLUMNS FROM `$tableName` ;";
        
        $engineList = $db->fetchAssoc($sql);
    	
        foreach ($engineList as $engine)
        {                	
            $list[$i]['val'] = $engine['Field'];
            $list[$i]['txt'] = $engine['Field'];
            $i++;        	
        }
    }   
}
?>