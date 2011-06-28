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
class ToolListbox extends Listbox
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
        $dbinfo = BizSystem::configuration()->getDatabaseInfo();
        $i = 0;
        foreach ($dbinfo as $db)
        {
            $list[$i]['val'] = $db['Name'];
            $list[$i]['txt'] = $db['Name'];
            $i++;
        }
        return $list;
    }
    
    protected function tables($dbStr)
    {
        if (!$dbStr)
        {
            $xp_DBName = "/BizDataObj/@DBName";
            $dbNameAttr = $this->getFormObj()->QueryXpath($xp_DBName);
            $dbName = $dbNameAttr->value;
        }
        else
        {
            if (strpos($dbStr,'$') === 0)
            {
                $db_fld = substr($dbStr, 1);
                $dbName = $this->getFormObj()->getElement($db_fld)->m_Value;
            }
            else
            {
                $xp_DBName = $dbStr;
                $dbNameAttr = $this->getFormObj()->QueryXpath($xp_DBName);
                $dbName = $dbNameAttr->value;
            }
        }
        
        global $g_BizSystem;
        $db = $g_BizSystem->getDBConnection($dbName);
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
    
    protected function columns($tableStr, $joinFld=null)
    {
        // get the join attribute first. If join found, use table of the join
        if ($joinFld)
        {
            $joinFld = substr($joinFld, 1);
            $fld_joinVal = $this->getFormObj()->getElement($joinFld)->m_Value;
            if ($fld_joinVal)
            {
                $xpathStr = "/BizDataObj/TableJoins/Join[@Name='".$fld_joinVal."']";
                $joinElem = $this->getFormObj()->QueryXpath($xpathStr); 
                $table = $joinElem->getAttribute('Table');
            }
        }
        
        $xp_DBName = "/BizDataObj/@DBName";
        $dbNameAttr = $this->getFormObj()->QueryXpath($xp_DBName);
        $dbName = $dbNameAttr->value ? $dbNameAttr->value : "Default";
        if (!$table)
        {
            if (strpos($tableStr,'$') === 0)
            {
                $table_fld = substr($tableStr, 1);
                $table = $this->getFormObj()->getElement($table_fld)->m_Value;
                //print_r($this->getFormObj()->getElement($table_fld));
            }
            else
            {
                $xp_Table = $tableStr;
                $tableAttr = $this->getFormObj()->QueryXpath($xp_Table);
                $table = $tableAttr->value;
            }
        }
        if ($table == "")
        {
            $list[$i]['val'] = ""; 
            $list[$i]['txt'] = "";
            return $list;
        }
        global $g_BizSystem;
        $db = $g_BizSystem->getDBConnection($dbName);
        
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
    
    // get fields of this DataObj or another DataObj
    protected function fields($xp_BizDataObj=null)
    {
        if (!$xp_BizDataObj)
        {
            // get fields of this DataObj
            $xpathStr = "/BizDataObj/BizFieldList/BizField";
            $elems = $this->getFormObj()->QueryXpath($xpathStr, false);
        }
        else
        {
            $doAttr = $this->getFormObj()->QueryXpath($xp_BizDataObj);
            $doName = $doAttr->value;
            
            // get the dataobj file
            $metaFileInfo = $this->getFormObj()->GetMetaFileInfo();
            if (!$metaFileInfo)
                return array();
            //echo "meta file info:"; print_r($metaFileInfo);
            if ($doName && !strpos($doName, ".") && ($metaFileInfo['package'])) // no package prefix as package.object, add it
                $doName = $metaFileInfo['package'].".".$doName;
            $doFile = $metaFileInfo['modules_path'].str_replace(".","/",$doName).'.xml';
            
            // get the fields of the dataobj
            $xpathStr = "/BizDataObj/BizFieldList/BizField";
            if (!file_exists($doFile)) 
                return array();
            $doc = new DomDocument();
            $ok = $doc->load($doFile);
            if (!$ok)
                return array();
            $xpath = new DOMXPath($doc);
            $elems = $xpath->query($xpathStr);
        }
        $i = 0;
        $list[$i]['val'] = "";
        $list[$i]['txt'] = "";
        $i++;
        foreach ($elems as $elem)
        {
            $list[$i]['val'] = $elem->getAttribute('Name');
            $list[$i]['txt'] = $elem->getAttribute('Name') . " (" . $elem->getAttribute('Column');
            $join = $elem->getAttribute('Join');
            if ($join && $join != "")
                $list[$i]['txt'] .= ", join: $join)";
            else
                $list[$i]['txt'] .= ")";
            $i++;
        }
        return $list;
    }
    
    protected function joins()
    {
        $xpathStr = "/BizDataObj/TableJoins/Join";
        $joinElems = $this->getFormObj()->QueryXpath($xpathStr, false); // return multiple
        $i = 0;
        $list[$i]['val'] = "";
        $list[$i]['txt'] = "";
        $i++;
        foreach ($joinElems as $join)
        {
            $list[$i]['val'] = $join->getAttribute('Name');
            $list[$i]['txt'] = $join->getAttribute('Name')." (".$join->getAttribute('Table').".".$join->getAttribute('Column').")";
            $i++;
        }
        return $list;
    }
    
    protected function references()
    {
        $xpathStr = "/EasyView/FormReferences/Reference";
        $refElems = $this->getFormObj()->QueryXpath($xpathStr, false); // return multiple
        $i = 0;
        $list[$i]['val'] = "";
        $list[$i]['txt'] = "";
        $i++;
        foreach ($refElems as $ref)
        {
            $list[$i]['val'] = $ref->getAttribute('Name');
            $list[$i]['txt'] = $ref->getAttribute('Name');
            $i++;
        }
        return $list;
    }
    
    /*// select do in form
    protected function dos()
    {
        $metaFileInfo = $this->getFormObj()->GetMetaFileInfo();
        $modulePath = $metaFileInfo['modules_path'];
        $modulePath = substr($modulePath,0,strlen($modulePath)-1);
        global $g_MetaFiles;
        php_grep("<BizDataObj", $modulePath);
        
        for ($i=0; $i<count($g_MetaFiles); $i++)
        {
            $g_MetaFiles[$i] = str_replace('/','.',str_replace(array($modulePath.'/','.xml'),'', $g_MetaFiles[$i]));
            $list[$i]['val'] = $g_MetaFiles[$i];
            $list[$i]['txt'] = $g_MetaFiles[$i];
        }

        return $list;  
    }*/
    
    // select do in form
    protected function dos()
    {
        $metaFileInfo = $this->getFormObj()->GetMetaFileInfo();
        $modulePath = $metaFileInfo['modules_path'];
        $packs = explode(".",$metaFileInfo['package']);
        $moduleName = $packs[0];
        $modulePath = MODULE_PATH.'/'.$moduleName; //substr($modulePath,0,strlen($modulePath)-1);
        global $g_MetaFiles;
        php_grep("<BizDataObj", $modulePath);
        
        for ($i=0; $i<count($g_MetaFiles); $i++)
        {
            $g_MetaFiles[$i] = $moduleName.'.'.str_replace('/','.',str_replace(array($modulePath.'/','.xml'),'', $g_MetaFiles[$i]));
            $list[$i]['val'] = $g_MetaFiles[$i];
            $list[$i]['txt'] = $g_MetaFiles[$i];
        }

        return $list;  
    }
    
    // select form in view
    protected function forms()
    {
        $metaFileInfo = $this->getFormObj()->GetMetaFileInfo();
        $modulePath = $metaFileInfo['modules_path'];
        $modulePath = substr($modulePath,0,strlen($modulePath)-1);
        global $g_MetaFiles;
        php_grep("<EasyForm", $modulePath);
        
        for ($i=0; $i<count($g_MetaFiles); $i++)
        {
            $g_MetaFiles[$i] = str_replace('/','.',str_replace(array($modulePath.'/','.xml'),'', $g_MetaFiles[$i]));
            $list[$i]['val'] = $g_MetaFiles[$i];
            $list[$i]['txt'] = $g_MetaFiles[$i];
        }

        return $list;  
    }
}

$g_MetaFiles = array();

function php_grep($q, $path)
{    
    global $g_MetaFiles;
    $fp = opendir($path);
    while($f = readdir($fp))
    {
    	if ( preg_match("#^\.+$#", $f) ) continue; // ignore symbolic links
    	$file_full_path = $path.'/'.$f;
    	if(is_dir($file_full_path)) 
    	{
    		php_grep($q, $file_full_path);
    	} 
    	else 
    	{
    		$path_parts = pathinfo($f);
    		if ($path_parts['extension'] != 'xml') continue; // consider only xml files
    		
    		//echo file_get_contents($file_full_path); exit;
    		if( stristr(file_get_contents($file_full_path), $q) ) 
    		    $g_MetaFiles[] = $file_full_path;
    	}
    }
}

?>
