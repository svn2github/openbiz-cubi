<?php

$g_ReportDBConns = array();

class ReportDO extends BizDataObj
{
	public $m_DbId;
	protected $_dbConnect;
	protected $_joinList = array();
	
	public function setAttributes($doRecord)
	{
		$fieldDOName = "report.do.ReportDoFieldDO";
		$joinDOName = "report.do.ReportDoJoinDO";

		$this->m_Id = $doRecord['Id'];
		$this->m_Name .= ':'.$doRecord['name'];
		$this->m_MainTable = $doRecord['table'];
		$this->m_Database = $doRecord['database'];
		$this->m_BaseSortRule = $this->m_SortRule = $doRecord['sort_rule'];
		$this->m_BaseSearchRule = $this->m_SearchRule = $doRecord['search_rule'];
		$group_by = isset($doRecord['group_by']) && !empty($doRecord['group_by']) ? 'GROUP BY '.$doRecord['group_by'] : '';
		$this->m_BaseOtherSQLRule = $this->m_OtherSQLRule = $group_by;
		$this->m_DbId = $doRecord['db_id'];
		
		// TODO
		// fetch joins records
		$joinDO = BizSystem::getObject($joinDOName);
        $joinRecords = $joinDO->directFetch("[do_id]=$this->m_Id");
		// create join objects
		$this->initJoinObjects($joinRecords);
		
        // fetch fields records
	    $fldDO = BizSystem::getObject($fieldDOName);
        $fldRecords = $fldDO->directFetch("[do_id]=$this->m_Id");
        // create element objects.
        $this->initFieldObjects($fldRecords);
        
        $db = $this->getDBConnection();
	}
    
    public function closeDBConnection()
    {
        if ($this->_dbConnect) {
            $this->_dbConnect->closeConnection();
            $this->_dbConnect = null;
        }
    }
	
	/**
     * Get database connection
     *
     * @return Zend_Db_Adapter_Abstract
     **/
    public function getDBConnection()
    {
        $databaseDO = "report.do.ReportDbDO";
        if (!$this->_dbConnect) 
        {
            // fetch fields records
    	    $dbDO = BizSystem::getObject($databaseDO);
            $dbRecord = $dbDO->fetchById($this->m_DbId);
            $this->_dbConnect = $this->_getDBConnection($dbRecord);
        }
        return $this->_dbConnect;
    }
    
    /**
     * Get the database connection object
     *
     * @param string $dbname, database name declared in config.xml
     * @return Zend_Db_Adapter_Abstract
     */
    protected function _getDBConnection($dbRecord)
    {
        global $g_ReportDBConns;
        $db_alias = $dbRecord["server"]."_".$dbRecord["db_name"];
        if (isset($g_ReportDBConns[$db_alias])) {
            return $g_ReportDBConns[$db_alias];
        }
        
        require_once 'Zend/Db.php';

        $params = array (
                'host'     => $dbRecord["server"],
                'username' => $dbRecord["username"],
                'password' => $dbRecord["password"],
                'dbname'   => $dbRecord["db_name"],
                'port'     => $dbRecord["port"],
                'charset'  => $dbRecord["charset"]
        );

        $db = Zend_Db::factory($dbRecord["driver"], $params);

        $db->setFetchMode(PDO::FETCH_NUM);

        if(strtoupper($dbInfo["Driver"])=="PDO_MYSQL" &&
                $dbInfo["Charset"]!="")
        {
            $db->query("SET NAMES '".$params['charset']."'");
        }
        $g_ReportDBConns[$db_alias] = $db;

        return $db;
    }
	
	protected function initFieldObjects($fldRecords)
    {
    	foreach ($fldRecords as $fldRec)
        {
			$_xmlArr["ATTRIBUTES"]["NAME"] = $fldRec['name'];
			$_xmlArr["ATTRIBUTES"]["COLUMN"] = $fldRec['column'];
			$_xmlArr["ATTRIBUTES"]["FORMAT"] = $fldRec['format'];
			$_xmlArr["ATTRIBUTES"]["TYPE"] = $fldRec['type'];
			$_xmlArr["ATTRIBUTES"]["SQLEXPR"] = $fldRec['sql_expr'];
			if (isset($this->_joinlist[$fldRec['join_id']]))
				$_xmlArr["ATTRIBUTES"]["JOIN"] = $this->_joinlist[$fldRec['join_id']];
			else 
				$_xmlArr["ATTRIBUTES"]["JOIN"] = null;
			$_xmlArr["ATTRIBUTES"]["VALUE"] = $fldRec['value'];
			$xmlArr[] = $_xmlArr;
        }
        $this->m_BizRecord = new BizRecord($xmlArr,"BizField",$this);
        foreach ($this->m_BizRecord as $field)
            $field->m_BizObjName = $this->m_Name;
    }
	
	protected function initJoinObjects($joinRecords)
    {
    	foreach ($joinRecords as $joinRec)
        {
			$_xmlArr["ATTRIBUTES"]["NAME"] = $joinRec['name'];
			$_xmlArr["ATTRIBUTES"]["TABLE"] = $joinRec['table'];
			$_xmlArr["ATTRIBUTES"]["COLUMN"] = $joinRec['column'];
			$_xmlArr["ATTRIBUTES"]["JOINTYPE"] = $joinRec['jointype'];
			$_xmlArr["ATTRIBUTES"]["COLUMNREF"] = $joinRec['columnref'];
			$_xmlArr["ATTRIBUTES"]["JOINREF"] = $joinRec['joinref'];
			$xmlArr[] = $_xmlArr;
			$this->_joinlist[$joinRec['Id']] = $joinRec['name'];
        }
        $this->m_TableJoins = new MetaIterator($xmlArr,"TableJoin",$this);
        foreach ($this->m_BizRecord as $field)
            $field->m_BizObjName = $this->m_Name;
    }
}

?>