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
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: RowCheckbox.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

include_once("Element.php");

/**
 * RowCheckbox class is input element for render RowCheckbox
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class RowCheckbox extends InputElement
{
    /**
     * Render label
     *
     * @return string HTML text
     */
    public function renderLabel()
    {
        $formName = $this->m_FormName;
        $name = $this->m_Name.'[]';
        $sHTML = "<INPUT TYPE=\"CHECKBOX\" onclick=\"Openbiz.Util.checkAll(this, $('$formName')['$name']);\"/>";
        return $sHTML;
    }

    /**
     * Render, draw the element according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $value = $this->m_Value;
        $name = $this->m_Name.'[]';
        $sHTML = "<INPUT TYPE=\"CHECKBOX\" NAME=\"$name\" VALUE='$value' onclick=\"event.cancelBubble=true;\"/>";
        return $sHTML;
    }
}

?>