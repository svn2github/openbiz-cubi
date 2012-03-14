<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
include_once (MODULE_PATH."/report/lib/DBUtil.php");

class ColumListbox extends Listbox
{

 	public function getFromList(&$list)
    {
    	$selectFrom = $this->getSelectFrom();
		
		$do_id = $selectFrom;
		if (!$do_id) return;
		
		$doObj = BizSystem::getObject('report.admin.do.ReportDoDO');
		$doArr = $doObj->fetchById($do_id);
		if (empty($doArr)) return;
		
		$db_id = $doArr['db_id'];  
		$table = $doArr['table'];
		
		$db = DBUtil::getDBConnection($doArr);

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
}
?>