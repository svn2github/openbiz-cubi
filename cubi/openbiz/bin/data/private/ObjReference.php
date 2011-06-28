<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.data.private
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: ObjReference.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */


/**
 * ObjReference class defines the object reference of a BizDataObj
 *
 * @package openbiz.bin.data.private
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 */
class ObjReference extends MetaObject
{
    public $m_Relationship;
    /**
     * Table name
     *
     * @var string
     */
    public $m_Table;
    /**
     * Column name
     *
     * @var string
     */
    public $m_Column;
    /**
     * Field name for reference
     *
     * @var string
     */
    public $m_FieldRef;
    public $m_XTable;
    public $m_XColumn1;
    public $m_XColumn2;
    public $m_XKeyColumn;   // may not be used any more due to XDataObj
    public $m_XDataObj;
    /**
     * Is cascade action
     *
     * @var boolean
     */
    public $m_CascadeDelete=false;
    public $m_OnDelete;
    public $m_OnUpdate;
    //public $m_Association;

    /**
     * Initialize ObjReference with xml array
     *
     * @param array $xmlArr
     * @param BizDataObj $bizObj
     * @return void
     */
    function __construct(&$xmlArr, $bizObj)
    {
        $this->m_Name = isset($xmlArr["ATTRIBUTES"]["NAME"]) ? $xmlArr["ATTRIBUTES"]["NAME"] : null;
        $this->m_Package = $bizObj->m_Package;
        $this->m_Description= isset($xmlArr["ATTRIBUTES"]["DESCRIPTION"]) ? $xmlArr["ATTRIBUTES"]["DESCRIPTION"] : null;
        $this->m_Relationship = isset($xmlArr["ATTRIBUTES"]["RELATIONSHIP"]) ? $xmlArr["ATTRIBUTES"]["RELATIONSHIP"] : null;
        $this->m_Table = isset($xmlArr["ATTRIBUTES"]["TABLE"]) ? $xmlArr["ATTRIBUTES"]["TABLE"] : null;
        $this->m_Column = isset($xmlArr["ATTRIBUTES"]["COLUMN"]) ? $xmlArr["ATTRIBUTES"]["COLUMN"] : null;
        $this->m_FieldRef = isset($xmlArr["ATTRIBUTES"]["FIELDREF"]) ? $xmlArr["ATTRIBUTES"]["FIELDREF"] : null;
        $this->m_CascadeDelete = (isset($xmlArr["ATTRIBUTES"]["CASCADEDELETE"]) && $xmlArr["ATTRIBUTES"]["CASCADEDELETE"] == "Y");
        $this->m_OnDelete = isset($xmlArr["ATTRIBUTES"]["ONDELETE"]) ? $xmlArr["ATTRIBUTES"]["ONDELETE"] : null;
        $this->m_OnUpdate = isset($xmlArr["ATTRIBUTES"]["ONUPDATE"]) ? $xmlArr["ATTRIBUTES"]["ONUPDATE"] : null;
        if ($this->m_CascadeDelete) $this->m_OnDelete = "Cascade";
        if ($this->m_Relationship == "M-M")
        {
            $this->m_XTable = isset($xmlArr["ATTRIBUTES"]["XTABLE"]) ? $xmlArr["ATTRIBUTES"]["XTABLE"] : null;
            $this->m_XColumn1 = isset($xmlArr["ATTRIBUTES"]["XCOLUMN1"]) ? $xmlArr["ATTRIBUTES"]["XCOLUMN1"] : null;
            $this->m_XColumn2 = isset($xmlArr["ATTRIBUTES"]["XCOLUMN2"]) ? $xmlArr["ATTRIBUTES"]["XCOLUMN2"] : null;
            $this->m_XKeyColumn = isset($xmlArr["ATTRIBUTES"]["XKEYCOLUMN"]) ? $xmlArr["ATTRIBUTES"]["XKEYCOLUMN"] : null;
            $this->m_XDataObj = isset($xmlArr["ATTRIBUTES"]["XDATAOBJ"]) ? $xmlArr["ATTRIBUTES"]["XDATAOBJ"] : null;
            $this->m_XDataObj = $this->prefixPackage($this->m_XDataObj);
        }
        //$this->m_Association = @$xmlArr["ATTRIBUTES"]["ASSOCIATION"];

        $this->m_Name = $this->prefixPackage($this->m_Name);
    }
}

?>