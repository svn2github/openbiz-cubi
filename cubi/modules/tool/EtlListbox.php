<?PHP

/**
 * FieldControl - class FieldControl is the base class of field control who binds with a bizfield
 *
 * @package BizView
 * @author rocky swen
 * @copyright Copyright (c) 2005
 * @version 1.2
 * @access public
 */
class EtlListbox extends EditCombobox
{
    /*  Special handling the SelectFrom
        dbs()
        tables(db)
        columns(db,table)
        fields(do)
        joins()
        references()
        ------------------
        dos()
        forms()
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
    
    protected function dbs()
    {
        $xp_DBName = "/ETL/DataSource/Database/@Name";
        $dbNames = $this->getFormObj()->QueryXpath($xp_DBName, false);

        $i = 0;
        foreach ($dbNames as $name)
        {
            $list[$i]['val'] = $name->value;
            $list[$i]['txt'] = $name->value;
            $i++;
        }
        return $list;
    }
    
    protected function tables($dbStr)
    {
        $elem = $this->getFormObj()->getCurrentElement();
        $queue = $elem->parentNode;
        $dbName = $queue->getAttribute($dbStr);
        if (!$dbName) return array();
        
        // get the db connection info from /ETL/DataSource/Database[@Name='...']
        $xpath = "/ETL/DataSource/Database[@Name='$dbName']";
        $dbElem = $this->getFormObj()->QueryXpath($xpath);

        $db = $this->getDBConnection($dbElem);
        $tables = $db->listTables();
        $i = 0;
        $list = array();
        foreach ($tables as $t)
        {
            $list[$i]['val'] = $t;
            $list[$i]['txt'] = $t;
            $i++;
        }
        return $list;
    }

    protected function getDBConnection($dbElem)
    {
        $driver = $dbElem->getAttribute('Driver');
        $server = $dbElem->getAttribute('Server');
        $port = $dbElem->getAttribute('Port');
        $db_name = $dbElem->getAttribute('DBName');
        $user = $dbElem->getAttribute('User');
        $pass = $dbElem->getAttribute('Password');
        
        require_once 'Zend/Db.php';

        $params = array (
                'host'     => $server,
                'username' => $user,
                'password' => $pass,
                'dbname'   => $db_name,
                'port'     => $port
        );
        $db = Zend_Db::factory($driver, $params);
        return $db;
    }
    
    protected function columns($dbStr,$tableStr)
    {
        $elem = $this->getFormObj()->getCurrentElement();
        $task = $elem->parentNode;
        $tableName = $task->getAttribute($tableStr);
        $queue = $task->parentNode;
        $dbName = $queue->getAttribute($dbStr);
        //echo "$dbName, $tableName"; 
        if (!$dbName) return array();
        
        // get the db connection info from /ETL/DataSource/Database[@Name='...']
        $xpath = "/ETL/DataSource/Database[@Name='$dbName']";
        $dbElem = $this->getFormObj()->QueryXpath($xpath);

        $db = $this->getDBConnection($dbElem);
        
        $tblCols = $db->describeTable($tableName);
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
