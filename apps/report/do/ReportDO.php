<?php

class ReportDO extends BizDataObj
{
	public $m_DbId;
	protected $_dbConnect;
	
	public function setAttributes($doRecord)
	{
		$fieldDO = "report.do.ReportDoFieldDO";

		$this->m_Id = $doRecord['Id'];
		$this->m_Name .= ':'.$doRecord['name'];
		$this->m_MainTable = $doRecord['table'];
		$this->m_Database = $doRecord['database'];
		$this->m_BaseSortRule = $this->m_SortRule = $doRecord['sort_rule'];
		$this->m_BaseSearchRule = $this->m_SearchRule = $doRecord['search_rule'];
		$group_by = isset($doRecord['group_by']) && !empty($doRecord['group_by']) ? 'GROUP BY '.$doRecord['group_by'] : '';
		$this->m_BaseOtherSQLRule = $this->m_OtherSQLRule = $group_by;
		$this->m_DbId = $doRecord['db_id'];
		
        // fetch fields records
	    $fldDO = BizSystem::getObject($fieldDO);
        $fldRecords = $fldDO->directFetch("[do_id]=$this->m_Id");
	
        // create element objects.
        $this->initFieldObjects($fldRecords);
        
        $db = $this->getDBConnection();
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

        return $db;
    }
	
	protected function initFieldObjects($fldRecords)
    {
    	foreach ($fldRecords as $fldRec)
        {
			$_xmlArr["ATTRIBUTES"]["NAME"] = $fldRec['name'];
			$_xmlArr["ATTRIBUTES"]["COLUMN"] = $fldRec['column'];
			$xmlArr[] = $_xmlArr;
        }
        $this->m_BizRecord = new BizRecord($xmlArr,"BizField",$this);
        foreach ($this->m_BizRecord as $field)
            $field->m_BizObjName = $this->m_Name;
    }
}

?>