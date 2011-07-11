<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy.element
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

/**
 * ColumnBool class is element for ColumnBool
 * show boolean on data list (table)
 *
 * @package openbiz.bin.easy.element
 * @author wangdong1984 
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class ColumnSearchRule extends ColumnText
{
    /**
     * Render element, according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $sHTML = "";
    	$queryData = unserialize($this->m_Value);
    	if (is_array($queryData)) {
    		$i = 0;
	        foreach ($queryData as $fieldName=>$value)
	        {
	        	$sHTML .= "$fieldName = $value";
	        	$i++;
	        	if ($i < count($queryData))
	        		$sHTML .= "; ";
	        }
    	}
        return $sHTML;
    }
}