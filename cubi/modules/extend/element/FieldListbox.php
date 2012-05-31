<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.extend.element
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class FieldListbox extends Listbox
{
	public function getFromList(&$list, $selectFrom=null)
    {
    	parent::getFromList($list, $selectFrom);
		$usedFields = $this->getUsedFields();
		for($i=0;$i<count($list);$i++)
		{
			foreach($usedFields as $field)
			{
				if($list[$i]['val']==$field && $list[$i]['val']!=$this->m_Value)
				{
					unset($list[$i]);
				}
			}
		}
    }
    
    protected function getUsedFields(){
    	$ds = $this->getFormObj()->getDataObj()->directfetch();
    	$fields = array();
    	foreach($ds as $record)
    	{
    		$fields[] = $record['field'];
    	}
    	return $fields;    	
    }
}
?>