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
 * @version   $Id: Button.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

include_once("InputElement.php");

/**
 * Button class is element for Button
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class Button extends InputElement
{
    /**
     * Image file name
     *
     * @var string
     */
    public $m_Image;

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_Image = isset($xmlArr["ATTRIBUTES"]["IMAGE"]) ? $xmlArr["ATTRIBUTES"]["IMAGE"] : null;
    }

    /**
     * Render element, according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $style = $this->getStyle();
        $func = $this->getEnabled() == 'N' ? "" : $this->getFunction();
        $id	   = $this->m_Name;

        if ($this->m_Image)
        {
            $imagesPath = Resource::getImageUrl();
            $out = "<img src=\"$imagesPath/" . $this->m_Image . "\" border=0 title=\"" . $this->m_Text . "\" />";
            if ($func != "")
                $out = "<a href='javascript:void(0);' $this->m_HTMLAttr $style $func>".$out."</a>";
        }
        else
        {
            $out = $this->getText();
            //$out = "<input id=\"$id\" type='button' value='$out' $this->m_HTMLAttr $style $func>";
            $out = "<a href='javascript:void(0);' $this->m_HTMLAttr $style $func>".$out."</a>";
        }

        return $out . "\n" . $this->addSCKeyScript();
    }
}

?>
