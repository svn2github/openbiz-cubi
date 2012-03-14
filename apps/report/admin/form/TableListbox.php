<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
include_once (MODULE_PATH."/report/lib/DBUtil.php");

class TableListbox extends Listbox
{

 	//public function getFromList(&$list)
	public function getFromList(&$list)
    {
		$selectFrom = $this->getSelectFrom();
		
		$db_id = $selectFrom;
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
        $tables = $db->listTables();
        $i = 0;
        foreach ($tables as $t)
        {
            $list[$i]['val'] = $t;
            $list[$i]['txt'] = $t;
            $i++;
        }
    }
}
?>