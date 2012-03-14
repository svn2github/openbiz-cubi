<?PHP
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
include_once (MODULE_PATH."/report/lib/DBUtil.php");

/**
 * FieldControl - class FieldControl is the base class of field control who binds with a bizfield
 *
 * @package BizView
 * @author rocky swen
 * @copyright Copyright (c) 2005
 * @version 1.2
 * @access public
 */
class DataObjListbox extends Listbox
{
    /*  Special handling the SelectFrom
        tables(db_id)
        columns(db_id,table)
        joins(do_id)
    */
    public function getFromList(&$list)
    {
        $selFrom = $this->getSelectFrom();
        
        $selFrom = $this->evalSelectFrom($selFrom);
        list($func,$body) = explode("(",$selFrom);
        $body = str_replace(")","",$body);
        if (strpos($body,",")>0)
            $args = explode(",",$body);
        else
            $args[0] = $body;

        if (method_exists($this, $func))
           $list = call_user_func_array(array($this, $func),$args);
    }
    
    protected function evalSelectFrom($selFrom)
    {
        return $selFrom;
    }
	
	protected function getDbConnByDBID($db_id)
	{
		if (!$db_id) return;
		
    	$dbobj = BizSystem::getObject('report.admin.do.ReportDbDO');
        $dbArr = $dbobj->fetchById($db_id);
		if (empty($dbArr)) return;

    	$server 	= $dbArr['server'];
    	$port 		= $dbArr['port'];
    	$driver 	= $dbArr['driver'];
    	$username 	= $dbArr['username'];
    	$password 	= $dbArr['password'];
    	$database 	= $dbArr['db_name'];
    	$charset 	= 'UTF8';
		
		$db = DBUtil::getDBConnection($dbArr);
		return $db;
	}
    
    protected function tables($db_id)
    {
		if (!$db_id) return array();
		$db = $this->getDbConnByDBID($db_id);
        $tables = $db->listTables();
        $i = 0;
        foreach ($tables as $t)
        {
            $list[$i]['val'] = $t;
            $list[$i]['txt'] = $t;
            $i++;
        }
		return $list;
    }
    
    protected function columns($db_id, $table)
    {
		if (!$db_id || !$table) return array();
		BizSystem::log(LOG_DEBUG, "DOListbox", "columns($db_id, $table)");
		$db = $this->getDbConnByDBID($db_id);
		$tblCols = $db->describeTable($table);
        $i = 0;
        foreach ($tblCols as $colName=>$colAttrs)
        {
            $list[$i]['val'] = $colName;
            $list[$i]['txt'] = $colName . "  (" . $colAttrs['DATA_TYPE'] . ")";
            $i++;
        }
        return $list;
    }
    
    protected function joins($do_id)
    {

    }

}
?>
