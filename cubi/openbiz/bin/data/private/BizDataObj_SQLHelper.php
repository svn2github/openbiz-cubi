<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.data.private
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: BizDataObj_SQLHelper.php 3994 2011-04-28 12:39:54Z jixian2003 $
 */

/**
 * Class BizDataObj_SQLHelper takes care of building sql for BizDataObj
 * BizDataObj_SQLHelper is singleton object
 *
 * @package openbiz.bin.data.private
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 */
class BizDataObj_SQLHelper
{
    /**
     *
     * @var BizDataSql
     */
    private $_dataSqlObj = null;

    /**
     *
     * @var BizDataObj_SQLHelper
     */
    private static $_instance = null;

    /**
     * Get the singleton instance
     *
     * @return BizDataObj_SQLHelper BizDataObj_SQLHelper object
     */
    public static function instance()
    {
        if (self::$_instance == null)
            self::$_instance = new BizDataObj_SQLHelper();
        return self::$_instance;
    }

    /**
     * Get curent BizDataSql object, if object=null, create new object
     *
     * @return BizDataSql
     */
    protected function getDataSqlObj()
    {
        if (!$this->_dataSqlObj)
            $this->_dataSqlObj = new BizDataSql();
        return $this->_dataSqlObj;
    }

    /**
     * Get new BizDataSql object and store on internal variable (current object)
     *
     * @return BizDataSql
     */
    protected function getNewDataSqlObj()
    {
        $this->_dataSqlObj = null;
        $this->_dataSqlObj = new BizDataSql();
        return $this->_dataSqlObj;
    }

    /**
     * Build the Select SQL statement based on the fields and search/sort rule
     *
     * @param BizDataObj $dataObj
     * @return void
     */
    public function buildQuerySQL($dataObj)
    {
        // TODO: if no searchrule or sortrule change ...
        // build the SQL statement based on the fields and search rule
        $dataSqlObj = $this->getNewDataSqlObj();
        // add table
        $dataSqlObj->addMainTable($dataObj->m_MainTable);
        // add join table
        if ($dataObj->m_TableJoins)
        {
            foreach($dataObj->m_TableJoins as $tableJoin)
            {
                $tbl_col = $dataSqlObj->addJoinTable($tableJoin);
            }
        }
        // add columns
        foreach($dataObj->m_BizRecord as $bizFld)
        {
            if ($bizFld->m_IgnoreInQuery) // field to be ignore in query - save memory
                continue;
            if ($bizFld->m_Column && $bizFld->m_Type == "Blob")   // ignore blob column
                continue;
            if ($bizFld->m_Column && !$bizFld->m_SqlExpression && (strpos($bizFld->m_Column,',') == 0))
                $dataSqlObj->addTableColumn($bizFld->m_Join, $bizFld->m_Column, $bizFld->m_Alias);
            if ($bizFld->m_SqlExpression)
            {
                $dataSqlObj->addSqlExpression($this->_convertSqlExpression($dataObj, $bizFld->m_SqlExpression),$bizFld->m_Alias);
            }
        }

        $dataSqlObj->resetSQL();

        // append DataPerm in the WHERE clause
        if($dataObj->m_DataPermControl=='Y')
        {
	        $svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	        $hasOwnerField = $this->_hasOwnerField($dataObj);
	        $dataPermSQLRule = $svcObj->buildSqlRule($dataObj,'select',$hasOwnerField);
	        $sqlSearchRule = $this->_ruleToSql($dataObj, $dataPermSQLRule);
	        $dataSqlObj->addSqlWhere($sqlSearchRule);
        }
        
        // append SearchRule in the WHERE clause
        $sqlSearchRule = $this->_ruleToSql($dataObj, $dataObj->m_SearchRule);
        $dataSqlObj->addSqlWhere($sqlSearchRule);

        // append SearchRule in the ORDER BY clause
        $sqlSortRule = $this->_ruleToSql($dataObj, $dataObj->m_SortRule);
        $dataSqlObj->addOrderBy($sqlSortRule);

        // append SearchRule in the other SQL clause
        $sqlOtherSQLRule = $this->_ruleToSql($dataObj, $dataObj->m_OtherSQLRule);
        $dataSqlObj->addOtherSQL($sqlOtherSQLRule);

        // append SearchRule in the AccessRule clause
        $sqlAccessSQLRule = $this->_ruleToSql($dataObj, $dataObj->m_AccessRule);
        $dataSqlObj->addSqlWhere($sqlAccessSQLRule);

        // add association to SQL
        if ($dataObj->m_Association["AsscObjName"] != ""
                && $dataObj->m_Association["FieldRefVal"] == "")
        {
            $asscObj = BizSystem::getObject($dataObj->m_Association["AsscObjName"]);
            $dataObj->m_Association["FieldRefVal"] = $asscObj->getFieldValue($dataObj->m_Association["FieldRef"]);
        }
        
    	if ($dataObj->m_Association["AsscObjName"] != ""
                && $dataObj->m_Association["FieldRefVal2"] == "")
        {
            $asscObj = BizSystem::getObject($dataObj->m_Association["AsscObjName"]);
            $dataObj->m_Association["FieldRefVal2"] = $asscObj->getFieldValue($dataObj->m_Association["FieldRef2"]);
        }
        
        if($dataObj->m_Association["Relationship"]=="Self-Self")
        {        	
        	$dataObj->m_Association["ParentRecordIdColumn"] = $dataObj->getField("Id")->m_Column;
        }
        $dataSqlObj->addAssociation($dataObj->m_Association);

        $querySQL = $dataSqlObj->getSqlStatement() . " ";

        //echo $dataobj->m_QuerySQL."###<br>";
        return $querySQL;
    }

    /**
     * Build update sql
     * UPDATE table SET col1=val1, col2=val2 ...
     * WHERE idcol1='id1' AND idcol2='id2'
     *
     * @param BizDataObj $dataObj
     * @return mixed
     * @todo consider the record data on main table as well as join table, this function can return a sql array.
     **/    
    public function buildUpdateSQL($dataObj)
    {
        // generate column value pairs. ignore those whose inputValue=fieldValue
        $sqlFlds = $dataObj->m_BizRecord->getToSaveFields('UPDATE');
        $colval_pairs = null;
        foreach($sqlFlds as $fldobj)
        {
            $col = $fldobj->m_Column;

            // ignore empty vallue for Date or Datetime
            if (($fldobj->m_Value == "" && $fldobj->m_OldValue == "")
                    && ($fldobj->m_Type == "Date" || $fldobj->m_Type == "Datetime"))
                continue;

            if ($fldobj->m_ValueOnUpdate != "") // ignore ValueOnUpdate field first
                continue;

            if ($fldobj->isLobField())  // take care of blob/clob type later
                continue;

            // ignore the column where old value is same as new value; set the column only if new value is diff than the old value
            if ($fldobj->m_OldValue == $fldobj->m_Value)
                continue;

            $_val = $fldobj->getSqlValue();
            $colval_pairs[$col] = $_val; //($_val===null || $_val === '') ? "''" : $_val;
        }
        if ($colval_pairs == null) return false;

        // take care value on update fields only
        foreach($sqlFlds as $fldobj)
        {
            $col = $fldobj->m_Column;
            if ($fldobj->m_ValueOnUpdate != "")
            {
                $_val = $fldobj->getValueOnUpdate();
                $colval_pairs[$col] = $_val; //($_val===null || $_val === '') ? "''" : $_val;
            }
        }

        $sql = "";
        foreach ($colval_pairs as $col=>$val)
        {
            $queryString = QueryStringParam::formatQueryString("`$col`", "=", $val);
            if ($sql!="") $sql .= ", $queryString";
            else $sql .= $queryString;
        }

        $sql = "UPDATE `" . $dataObj->m_MainTable . "` SET " . $sql;

        $whereStr = $dataObj->m_BizRecord->getKeySearchRule(true, true);  // use old value and column name
        $sql .= " WHERE " . $whereStr;
    	
        // append DataPerm in the WHERE clause
        if($dataObj->m_DataPermControl=='Y')
        {
	        $svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	        $hasOwnerField = $this->_hasOwnerField($dataObj);
	        $dataPermSQLRule = $svcObj->buildSqlRule($dataObj,'update',$hasOwnerField);
	        $sqlSearchRule = $this->_convertSqlExpressionWithoutPrefix($dataObj, $dataPermSQLRule);
	        if($whereStr!='')
	        {
	        	$sql .= ' AND '.$sqlSearchRule;
	        }else
	        {	        
	        	$sql .= $sqlSearchRule;
	        }
        }
        return $sql;
    }
    
    public function buildUpdateSQLwithCondition($dataObj, $setValue, $condition = null)
    {   
    	     
        $setValueStr = $this->_convertSqlExpressionWithoutPrefix($dataObj, $setValue);                 
        $sql = "UPDATE `" . $dataObj->m_MainTable ."` SET ".$setValueStr;
    	if($condition)
        {
        	$whereStr = $this->_convertSqlExpressionWithoutPrefix($dataObj, $condition); 
        	$sql .= " WHERE " . $whereStr;
        }
        
    	// append DataPerm in the WHERE clause
        if($dataObj->m_DataPermControl=='Y')
        {
	        $svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	        $hasOwnerField = $this->_hasOwnerField($dataObj);
	        $dataPermSQLRule = $svcObj->buildSqlRule($dataObj,'update',$hasOwnerField);
	        $sqlSearchRule = $this->_convertSqlExpressionWithoutPrefix($dataObj, $dataPermSQLRule);
	        if($whereStr!='')
	        {
	        	$sql .= ' AND '.$sqlSearchRule;
	        }else
	        {	        
	        	$sql .= $sqlSearchRule;
	        }
        }
        return $sql;
    }

    /**
     * Build delete-sql DELETE FROM table WHERE idcol1='id1' AND idcol2='id2'
     *
     * @param BizDataObj $dataObj
     * @return string SQL statement
     */
    public function buildDeleteSQL($dataObj)
    {
        $sql = "DELETE FROM `" . $dataObj->m_MainTable ."`";
        $whereStr = $dataObj->m_BizRecord->getKeySearchRule(false, true);  // use cur value and column name
        $sql .= " WHERE " . $whereStr;
    	// append DataPerm in the WHERE clause
        if($dataObj->m_DataPermControl=='Y')
        {
	        $svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	        $hasOwnerField = $this->_hasOwnerField($dataObj);
	        $dataPermSQLRule = $svcObj->buildSqlRule($dataObj,'delete',$hasOwnerField);
	        $sqlSearchRule = $this->_convertSqlExpressionWithoutPrefix($dataObj, $dataPermSQLRule);
	        if($whereStr!='')
	        {
	        	$sql .= ' AND '.$sqlSearchRule;
	        }else
	        {	        
	        	$sql .= $sqlSearchRule;
	        }
        }
        return $sql;
    }
    
    public function buildDeleteSQLwithCondition($dataObj, $condition = null)
    {
    	
        $sql = "DELETE FROM `" . $dataObj->m_MainTable . "`";  
        if($condition)
        {
        	$whereStr = $this->_convertSqlExpressionWithoutPrefix($dataObj, $condition); 
        	$sql .= " WHERE " . $whereStr;
        }
   		// append DataPerm in the WHERE clause
        if($dataObj->m_DataPermControl=='Y')
        {
	        $svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	        $hasOwnerField = $this->_hasOwnerField($dataObj);
	        $dataPermSQLRule = $svcObj->buildSqlRule($dataObj,'delete',$hasOwnerField);
	        $sqlSearchRule = $this->_convertSqlExpressionWithoutPrefix($dataObj, $dataPermSQLRule);
	        if($whereStr!='')
	        {
	        	$sql .= ' AND '.$sqlSearchRule;
	        }else
	        {	        
	        	$sql .= $sqlSearchRule;
	        }
        }
        return $sql;
    }

    /**
     * Build insert-sql
     * INSERT INTO table_name (column1, column2,...) VALUES (value1, value2,....)
     *
     * @param BizDataObj $dataObj
     * @param array $joinValues array of join values
     * @return string Insert-SQL statement
     */
    public function buildInsertSQL($dataObj, $joinValues=null)
    {
        // generate column value pairs.
        $sqlFlds = $dataObj->m_BizRecord->getToSaveFields('CREATE');

        $dbInfo = BizSystem::configuration()->getDatabaseInfo($dataObj->m_Database);
        $dbType = $dbInfo["Driver"];

        $sql_col = "";
        $sql_val = "";
        foreach($sqlFlds as $fldobj)
        {
            $col = $fldobj->m_Column;

            // if Field Id has null value and Id is an identity type, remove the Id's column from the array
            if ($fldobj->m_Name == "Id" && $dataObj->m_IdGeneration == "Identity")
                continue;

            if ($fldobj->isLobField())  // special value for blob/clob type
                $_val = $fldobj->getInsertLobValue($dbType);
            else
            {
            	$_val = $fldobj->getSqlValue();
                if ($_val =='' && $fldobj->m_ValueOnCreate != "")
                    $_val = $fldobj->getValueOnCreate();                
            }

            //if (!$_val || $_val == '') continue;
            // modified by jixian for not ignore 0 value
            if ( $_val === '') continue;
            $sql_col .= "`" . $col . "`, ";
            //$sql_val .= $_val. ", ";
            $sql_val .= QueryStringParam::formatQueryValue($_val). ", ";
        }

        // if joinValues is given then add join values in to the main table InsertSQL.
        if(is_array($joinValues))
        {
            foreach($joinValues as $joinColumn=>$joinValue)
            {
                if (!$joinValue || $joinValue == '') continue;
                $sql_col .= "`".$joinColumn. "`, ";
                $sql_val .= "'".$joinValue. "', ";
            }
        }

        $sql_col = substr($sql_col, 0, -2);
        $sql_val = substr($sql_val, 0, -2);

        $sql = "INSERT INTO  `" . $dataObj->m_MainTable . "` (" . $sql_col . ") VALUES (" . $sql_val.")";
        return $sql;
    }

    /**
     * Convert search/sort rule to sql clause, replace [fieldName] with table.column
     * openbiz SQL expression as :
     * "[fieldName] opr 'Value' AND/OR [fieldName] opr 'Value'...". "()" is valid syntax
     *
     * @param BizDataObj $dataObj
     * @param string $rule "[fieldName] ..."
     * @return string sql statement
     **/
    private function _ruleToSql($dataObj, $rule)
    {
        $dataSqlObj = $this->getDataSqlObj();

        $rule = Expression::evaluateExpression($rule,$dataObj);

        // replace all [field] with table.column
        foreach($dataObj->m_BizRecord as $bizFld)
        {
            if (!$bizFld->m_Column && !$bizFld->m_Alias && !$bizFld->m_SqlExpression)
                continue;   // ignore if no column mapped
            $fld_pattern = "[".$bizFld->m_Name."]";
            if (strpos($rule, $fld_pattern) === false)
                continue;   // ignore if no [field] found
            else
            {
                if ($bizFld->m_Column && (strpos($bizFld->m_Column,',') != 0))
                {  // handle composite key
                    preg_match('/\['.$bizFld->m_Name.'\].*=.*\'(.+)\'/', $rule, $matches); //print_r($matches);
                    $keyval = $matches[1];
                    $rule = $this->_compKeyRuleToSql($bizFld->m_Column,$keyval);
                }
                else
                {
                    if ($bizFld->m_Alias){
                        $rule = str_replace($fld_pattern, $bizFld->m_Alias, $rule);
                    }
                    elseif($bizFld->m_SqlExpression){
                    	$rule = str_replace($fld_pattern, $bizFld->m_SqlExpression, $rule);
                    }
                    else
                    {
                        $tableColumn = $dataSqlObj->getTableColumn($bizFld->m_Join, $bizFld->m_Column);
                        $rule = str_replace($fld_pattern, $tableColumn, $rule);
                    }
                }
            }
        }

        return $rule;
    }

    //TODO: refactor:rename, what's mean of comp?
    /**
     *
     * @param string $compColumn
     * @param string $compValue
     * @return string SQL rule statement
     */
    private function _compKeyRuleToSql($compColumn, $compValue)
    {
        $dataSqlObj = $this->getDataSqlObj();
        $colArr = explode(",", $compColumn);
        $valArr = explode(CK_CONNECTOR, $compValue);
        $sql = "";
        for ($i=0; $i < count($colArr); $i++)
        {
            if ($i>0) $sql .= "and";
            $tableColumn = $dataSqlObj->getTableColumn("", $colArr[$i]);
            if ($valArr[$i] == '')
                $sql .= " ($tableColumn = '" . $valArr[$i] . "' OR $tableColumn is null) ";
            else
                $sql .= " $tableColumn = '" . $valArr[$i] . "' ";
        }
        return $sql;
    }

    /**
     * Convert Sql Expression
     * Replace [field name] in the SQL expression with table_alias.column
     *
     * @param BizDataObj $dataObj - the instance of BizDataObj
     * @param string $sqlExpr - SQL expression supported by the database engine. The syntax is FUNC([FieldName1]...[FieldName2]...)
     * @return string real sql expression with column names
     **/
    private function _convertSqlExpression($dataObj, $sqlExpr)
    {
        $dataSqlObj = $this->getDataSqlObj();
        $sqlstr = $sqlExpr;
        $startpos = 0;
        while (true)
        {
            $fieldname = substr_lr($sqlstr,"[","]",$startpos);
            if ($fieldname == "") break;
            else
            {
                $bizFld = $dataObj->m_BizRecord->get($fieldname);
                $tableColumn = $dataSqlObj->getTableColumn($bizFld->m_Join, $bizFld->m_Column);
                $sqlstr = str_replace("[$fieldname]", $tableColumn, $sqlstr);
                $startpos = strpos($sqlstr, '['); // Move startpos to the first [ (if it exists) in order to be detect by next itteration
            }
        }
        return $sqlstr;
    }

    private function _convertSqlExpressionWithoutPrefix($dataObj, $sqlExpr)
    {
        $dataSqlObj = $this->getDataSqlObj();
        $sqlstr = $sqlExpr;
        $startpos = 0;
        while (true)
        {
            $fieldname = substr_lr($sqlstr,"[","]",$startpos);
            if ($fieldname == "") break;
            else
            {
                $bizFld = $dataObj->m_BizRecord->get($fieldname);
                $tableColumn = "`".$bizFld->m_Column."`";
                $sqlstr = str_replace("[$fieldname]", $tableColumn, $sqlstr);
                $startpos = strpos($sqlstr, '['); // Move startpos to the first [ (if it exists) in order to be detect by next itteration
            }
        }
        return $sqlstr;
    }    
    
    private function _hasOwnerField($dataObj){
    	$fld = $dataObj->getField('owner_id');
    	if($fld){
    		return true;
    	}else{
    		return false;
    	}
    }
}


/**
 * substr_lr() - help function (helper).
 * Get the sub string whose left and right boundary character is $left and $right.
 * The search is in $str, starting from position of $startpos.
 * If $findfirst is true, $left must be the charater on the $startpos.
 *
 * @return string
 **/
function substr_lr(&$str, $left, $right, &$startpos, $findfirst=false)
{
    $pos0 = strpos($str, $left, $startpos);
    if ($pos0 === false) return false;
    $tmp = trim(substr($str,$startpos,$pos0-$startpos));
    if ($findfirst && $tmp!="") return false;

    $posleft = $pos0+strlen($left);
    while(true)
    {
        $pos1 = strpos($str, $right, $posleft);
        if ($pos1 === false)
        {
            if (trim($right)=="")
            {
                $pos1 = strlen($str); // if right is whitespace
                break;
            }
            else return false;
        }
        else
        {   // avoid \$right is found
            if (substr($str,$pos1-1,1) == "\\")  $posleft = $pos1+1;
            else break;
        }
    }

    $startpos = $pos1 + strlen($right);
    $retStr = substr($str, $pos0 + strlen($left), $pos1-$pos0-strlen($left));
    return $retStr;
}

?>