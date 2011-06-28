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
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: InputElement.php 3174 2011-02-02 09:53:36Z jixian2003 $
 */

include_once("Element.php");

/**
 * InputElement class is based element for all input element
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class InputElement extends Element
{
    public $m_FieldName;
    public $m_Label;
    public $m_Description;
    public $m_DefaultValue = "";
    public $m_DefaultValueRename = "Y";
    public $m_Required = "N";
    public $m_Enabled = "Y";      // support expression
    public $m_Text;

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_FieldName = isset($xmlArr["ATTRIBUTES"]["FIELDNAME"]) ? $xmlArr["ATTRIBUTES"]["FIELDNAME"] : null;
        $this->m_Label = isset($xmlArr["ATTRIBUTES"]["LABEL"]) ? $xmlArr["ATTRIBUTES"]["LABEL"] : null;
        $this->m_DefaultValue = isset($xmlArr["ATTRIBUTES"]["DEFAULTVALUE"]) ? $xmlArr["ATTRIBUTES"]["DEFAULTVALUE"] : null;
        $this->m_DefaultValueRename = isset($xmlArr["ATTRIBUTES"]["DEFAULTVALUERENAME"]) ? $xmlArr["ATTRIBUTES"]["DEFAULTVALUERENAME"] : "Y";
        $this->m_Required = isset($xmlArr["ATTRIBUTES"]["REQUIRED"]) ? $xmlArr["ATTRIBUTES"]["REQUIRED"] : null;
        $this->m_Enabled = isset($xmlArr["ATTRIBUTES"]["ENABLED"]) ? $xmlArr["ATTRIBUTES"]["ENABLED"] : null;
        
        $this->m_FuzzySearch = isset($xmlArr["ATTRIBUTES"]["FUZZYSEARCH"]) ? $xmlArr["ATTRIBUTES"]["FUZZYSEARCH"] : null;
        $this->m_OnEventLog = isset($xmlArr["ATTRIBUTES"]["ONEVENTLOG"]) ? $xmlArr["ATTRIBUTES"]["ONEVENTLOG"] : null;
        $this->m_Validator = isset($xmlArr["ATTRIBUTES"]["VALIDATOR"]) ? $xmlArr["ATTRIBUTES"]["VALIDATOR"] : null;
        $this->m_ClientValidator = isset($xmlArr["ATTRIBUTES"]["CLIENTVALIDATOR"]) ? $xmlArr["ATTRIBUTES"]["CLIENTVALIDATOR"] : null;
        $this->m_AllowURLParam = isset($xmlArr["ATTRIBUTES"]["ALLOWURLPARAM"]) ? $xmlArr["ATTRIBUTES"]["ALLOWURLPARAM"] : 'Y';
        $this->m_KeepCookie = isset($xmlArr["ATTRIBUTES"]["KEEPCOOKIE"]) ? $xmlArr["ATTRIBUTES"]["KEEPCOOKIE"] : 'N';
        $this->m_CookieLifetime = isset($xmlArr["ATTRIBUTES"]["COOKIELIFETIME"]) ? (int)$xmlArr["ATTRIBUTES"]["COOKIELIFETIME"] : '3600';
        
        $this->m_cssClass = isset($xmlArr["ATTRIBUTES"]["CSSCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSCLASS"] : null;
        $this->m_cssErrorClass = isset($xmlArr["ATTRIBUTES"]["CSSERRORCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSERRORCLASS"] : "input_error";

        // if no class name, add default class name. i.e. NewRecord => ObjName.NewRecord
        $this->m_ValuePicker = $this->prefixPackage($this->m_ValuePicker);
    }



    /**
     * Get enable status
     *
     * @return string
     */
    protected function getEnabled()
    {
        $formObj = $this->getFormObj();
        //echo 'getenabled='.$this->m_Enabled;
        return Expression::evaluateExpression($this->m_Enabled, $formObj);
    }

    /**
     * Render label, just return label value
     *
     * @return string
     */
    public function renderLabel()
    {
        return $this->m_Label;
    }

    /**
     * Render, draw the element according to the mode
     * just return element value
     *
     * @return string HTML text
     */
    public function render()
    {
        return $this->m_Value;
    }

    /**
     * Add sort-cut key scripts
     *
     * @return string
     */
    protected function addSCKeyScript()
    {
        $keyMap = $this->getSCKeyFuncMap();
        if (count($keyMap) == 0)
            return "";
        BizSystem::clientProxy()->appendScripts("shortcut", "shortcut.js");
        $str = "<script>\n";
        $formObj = $this->getFormObj();
        if (!$formObj->removeall_sck) {
            $str .= " shortcut.removeall(); \n";
            $formObj->removeall_sck = true;
        }
        foreach ($keyMap as $key => $func)
            $str .= " shortcut.remove(\"$key\"); \n";
        $str .= " shortcut.add(\"$key\",function() { $func }); \n";
        $str .= "</script>\n";
        return $str;
    }
}

?>
