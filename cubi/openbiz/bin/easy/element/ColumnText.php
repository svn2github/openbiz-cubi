<?PHP
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
 * @version   $Id: ColumnText.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

include_once("LabelText.php");

/**
 * ColumnText class is element for ColumnText,
 * show text on data list
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class ColumnText extends LabelText
{
    public $m_Sortable;
    public $m_ColumnStyle;    

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_Sortable = isset($xmlArr["ATTRIBUTES"]["SORTABLE"]) ? $xmlArr["ATTRIBUTES"]["SORTABLE"] : null;        
        $this->m_ColumnStyle = $this->m_Style;
    }

    /**
     * Set the sort flag of the element
     *
     * @param integer $flag 1 or 0
     * @return void
     */
    public function setSortFlag($flag=null)
    {
        $this->m_SortFlag = $flag;
    }

    /**
     * Render label,
     * When render table, it return the table header; when render array, it return the display name
     *
     * @return string HTML text
     */
    public function renderLabel()
    {
        if ($this->m_Sortable == "Y")
        {
            $rule = $this->m_Name;

            $function = $this->m_FormName . ".SortRecord($rule,$this->m_SortFlag)";
            if($this->m_SortFlag == "ASC" || $this->m_SortFlag == "DESC"){
            	$class=" class=\"current\" ";
            }else{
            	$class=" class=\"normal\" ";
            }
            if ($this->m_SortFlag == "ASC")
            	$span_class = " class=\"sort_up\" ";
            else if ($this->m_SortFlag == "DESC")
                $span_class = " class=\"sort_down\" ";
            $sHTML = "<a href=javascript:Openbiz.CallFunction('" . $function . "') $class ><span $span_class >" . $this->m_Label ."</span>";            
            $sHTML .= "</a>";
        }
        else
        {
            $sHTML = $this->m_Label;
        }
        return $sHTML;
    }
    
    public function matchRemoteMethod($method)
    {
        return ($this->m_Sortable == "Y" && $method == "sortrecord");
    }
}
?>