<?php 
include_once OPENBIZ_BIN."/easy/element/Listbox.php";
class TableEngineListbox extends Listbox
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
    
    protected function _getDBConn()
    {
    	$dbConnForm = BizSystem::getObject("appbuilder.builder.ConfDBConnWizardForm");
		$dbRec = $dbConnForm->getActiveRecord();
		$dbName = $dbRec['NAME'];
		$db = BizSystem::instance()->getDBConnection($dbname);
		return $db;
    }
	    
    
    protected function getSimpleFromList(&$list, $selectFrom)
    {
		$sql = "SHOW ENGINES;";
        $db = $this->_getDBConn();
        $engineList = $db->fetchAssoc($sql);
    	
        foreach ($engineList as $engine)
        {        
        	if($engine['Support']!="NO")
        	{
	            $list[$i]['val'] = $engine['Engine'];
	            $list[$i]['txt'] = $engine['Engine'];
	            $i++;
        	}
        }
    }   
}
?>