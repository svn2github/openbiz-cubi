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

class AccessColumnList extends ColumnList
{
	
    protected function translateList(&$list, $tag)
    {	
		$package = $this->getSelectFrom();		
    	I18n::AddLangData(substr($package,0,intval(strpos($package,'.'))),"extend");
    	parent::translateList($list, $tag);
    }

}
?>