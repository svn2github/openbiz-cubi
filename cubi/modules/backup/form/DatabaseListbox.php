<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.backup.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once OPENBIZ_BIN."/easy/element/Listbox.php";

class DatabaseListbox extends Listbox
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
    
    protected function getSimpleFromList(&$list, $selectFrom)
    {
        // in case of a|b|c
        
    	$dbconfig = BizSystem::getConfiguration()->getDatabaseInfo();
    	
        foreach ($dbconfig as $rec=>$value)
        {        
            $list[$i]['val'] = $rec;
            $list[$i]['txt'] = $rec;
            $list[$i]['pic'] = $rec;
            $i++;
        }
    }    
    
}
?>