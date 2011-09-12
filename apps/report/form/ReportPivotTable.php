<?php

class ReportPivotTable extends EasyForm
{
    protected $pivotConfig, $pivotFields;
    protected $queryLimit = 1000;
    protected $baseForm;
    
    function __construct(&$xmlArr)
	{
		parent::__construct($xmlArr);
	}
    
    public function initPivot($baseForm, $pivotConfig)
    {
        $this->baseForm = $baseForm;
        $this->queryLimit = $pivotConfig->queryLimit;
        $rf_elem = $baseForm->getElement($pivotConfig->columnFields[0]);
        if (!$rf_elem) {
            throw new Exception("Please speficy a valid column field in Pivot table");
            return false;
        }
        
        $pivotFld['name'] = 'RF_'.$rf_elem->m_Name;
        $pivotFld['label'] = $rf_elem->m_Label;
        $pivotFld['type'] = 'column_field';
        $pivotFld['field'] = $rf_elem->m_FieldName;
        $this->pivotFields[$rf_elem->m_FieldName] = $pivotFld;
        
        if (empty($pivotConfig->rowFields)) {
            throw new Exception("Please speficy at least one valid row field in Pivot table");
            return false;
        }
        if (empty($pivotConfig->dataFields)) {
            throw new Exception("Please speficy a valid data field in Pivot table");
            return false;
        }
        
        foreach ($pivotConfig->rowFields as $rf) {
            $rf_elem = $baseForm->getElement($rf);
            //$rf_fld = $baseDO->getField($rf_elem->m_FieldName);
            $pivotFld['name'] = 'RF_'.$rf_elem->m_Name;
            $pivotFld['label'] = $rf_elem->m_Label;
            $pivotFld['type'] = 'row_field';
            $pivotFld['field'] = $rf_elem->m_FieldName;
            $this->pivotFields[$rf_elem->m_FieldName] = $pivotFld;
        }
        foreach ($pivotConfig->dataFields as $df) {
            $df_elem = $baseForm->getElement($df[0]);
            $pivotFld['name'] = 'DF_'.$df_elem->m_Name;
            $pivotFld['label'] = $df[1].'('.$df_elem->m_Label.')';
            $pivotFld['type'] = 'data_field';
            $pivotFld['field'] = $df_elem->m_FieldName;
            $pivotFld['function'] = $df[1];
            $this->pivotFields[$df_elem->m_FieldName] = $pivotFld;
        }
    }
    
    public function fetchDataSet()
    {
    }
    
	public function outputAttrs()
    {
        require_once 'Zend/Json.php'; 
        $output['name'] = $this->m_Name;
        $output['title'] = $this->m_Title;
        $output['description'] = str_replace('\n', "<br />", $this->m_Description);
        $metas = $this->getPivotMetas();
        foreach ($metas as $k=>$v) {
            $metas_json[$k] = Zend_Json::encode($v);
        }
        $output['meta'] = $metas_json;
        $output['data'] = Zend_Json::encode($this->getPivotData());
        return $output;
    }
    
    protected function getPivotMetas()
    {
        $metas = array('headers'=>array(), 'col_index'=>array(), 'row_index'=>array(), 'data_index'=>array(), 'filter_index'=>array());
        $baseDO = $this->baseForm->getDataObj();
        $i = 0;
        foreach ($baseDO->m_BizRecord as $fld) {
            if (isset($this->pivotFields[$fld->m_Name])) {
                $pf = $this->pivotFields[$fld->m_Name];
                $metas['headers'][] = $pf['label'];
                switch ($pf['type']) {
                    case 'column_field': $metas['col_index'][] = $i; break;
                    case 'row_field': $metas['row_index'][] = $i; break;
                    case 'data_field': $metas['data_index'] = $i; break;
                }
                $i++;
            }
        }
        return $metas;
    }
    
    protected function getPivotData() 
    {
        $baseDO = $this->baseForm->getDataObj();
        foreach ($baseDO->m_BizRecord as $fld) {
            if (!isset($this->pivotFields[$fld->m_Name]))
                $fld->m_IgnoreInQuery = true;
        }
        // run query on table
        $db = $baseDO->getDBConnection();
        $sqlHelper = BizDataObj_SQLHelper::instance();
        $sql = $sqlHelper->buildQuerySQL($baseDO);
        $hasGroupBy = stripos($sql, 'GROUP BY')>0 ? true : false;
        if (!$hasGroupBy && $this->queryLimit > 0) {
            $sql = $db->limit($sql, $this->queryLimit, 0);
        }
        try
        {
            $bindValues = QueryStringParam::getBindValues();
            $bindValueString = QueryStringParam::getBindValueString();
            BizSystem::log(LOG_DEBUG, "DATAOBJ", "Query Sql = ".$sql." BIND: $bindValueString");
            $resultSet = $db->query($sql, $bindValues);
            $resultSetArray = $resultSet->fetchAll();
        }
        catch (Exception $e)
        {
            BizSystem::log(LOG_ERR, "DATAOBJ", "Query Error: ".$e->getMessage());
            $this->m_ErrorMessage = $this->getMessage("DATA_ERROR_QUERY").": ".$sql.". ".$e->getMessage();
            throw new BDOException($this->m_ErrorMessage);
            return null;
        }
        return $resultSetArray;
    }
}
?>