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
 * @version   $Id: Radio.php 3671 2011-04-12 06:30:49Z jixian2003 $
 */

include_once("OptionElement.php");

/**
 * Radio class is element that show RadioBox with data from Selection.xml
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class Radio extends OptionElement
{
   
    /**
     * Render, draw the control according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $fromList = array();
        $this->getFromList($fromList);
        $disabledStr = ($this->getEnabled() == "N") ? "DISABLED=\"true\"" : "";
        if(!$this->m_Style){
        	$this->m_Style.="margin-right:8px;";
        }
        $style = $this->getStyle();
        $func = $this->getFunction();

        $value = $this->getValue()!='null' ? $this->getValue() : $this->getDefaultValue();
        foreach ($fromList as $option) {        	
            $checkedStr = ($option['val'] == $value) ? "CHECKED" : "";
            $sHTML .= "<label style=\"text-align:left;\"><INPUT TYPE=RADIO NAME='".$this->m_Name."' ID=\"" . $this->m_Name ."_".$option['val']."\" VALUE=\"" . $option['val'] . "\" $checkedStr $disabledStr $style $this->m_HTMLAttr $func />" . $option['txt'] . "</label>";
        }
        
        return $sHTML;
    }
}

?>
