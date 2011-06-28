<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: PickerForm.php 3149 2011-02-01 16:06:49Z jixian2003 $
 */

/**
 * PickerForm class - contains form object metadata functions for picker
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class PickerForm extends EasyForm
{
    /**
     *
     * @var string
     */
    public $m_ParentFormElemName = "";

    /**
     *
     * @var string
     */
    public $m_PickerMap = "";

    /**
     * Get/Retrieve Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function getSessionVars($sessionContext)
    {
        parent::getSessionVars($sessionContext);
        $sessionContext->getObjVar($this->m_Name, "ParentFormElemName", $this->m_ParentFormElemName);
        $sessionContext->getObjVar($this->m_Name, "PickerMap", $this->m_PickerMap);
    }

    /**
     * Save object variable to session context
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function setSessionVars($sessionContext)
    {
        parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "ParentFormElemName", $this->m_ParentFormElemName);
        $sessionContext->setObjVar($this->m_Name, "PickerMap", $this->m_PickerMap);
    }

    /**
     * Set parent form data/informations
     *
     * @param string $formName
     * @param string $elemName
     * @param string $pickerMap
     * @return void
     */
    public function setParentFormData($formName, $elemName=null, $pickerMap=null)
    {
        $this->m_ParentFormName = $formName;
        $this->m_ParentFormElemName = $elemName;
        $this->m_PickerMap = $pickerMap;
    }

    /**
     * Pick data to parent form
     *
     * @param <type> $recId
     * @return void
     * @access remote
     */
    public function pickToParent($recId=null)
    {
        /**
         * @todo $rec variable not used, need to remove ???
         */
        $rec = $this->getActiveRecord($recId);

        // if no parent elem or picker map, call AddToParent
        if (!$this->m_ParentFormElemName)
        {
            $this->addToParent($recId);
        }

        // if has parent elem and picker map, call JoinToParent
        if ($this->m_ParentFormElemName && $this->m_PickerMap)
        {
            $this->joinToParent($recId);
        }
    }

    /**
     * Join a record (popup) to parent form
     *
     * @param <type> $recId
     * @return void
     */
    public function joinToParent($recId=null)
    {
        $rec = $this->getActiveRecord($recId);

        $parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
        $updArray = array();

        // get the picker map of the control
        if ($this->m_PickerMap)
        {
            $pickerList = $this->_parsePickerMap($this->m_PickerMap);
            foreach ($pickerList as $ctrlPair)
            {
                $this_ctrl = $this->getElement($ctrlPair[1]);
                if (!$this_ctrl)
                    continue;
                $this_ctrl_val = $this_ctrl->getValue();
                $other_ctrl = $parentForm->getElement($ctrlPair[0]);
                if ($other_ctrl)
                    $updArray[$other_ctrl->m_Name] = $this_ctrl_val;
            }
        }
        else
            return;

        $this->close();

        BizSystem::clientProxy()->updateFormElements($parentForm->m_Name, $updArray);
    }

    /**
     * Add a record (popup) to the parent form if OK button clicked, (M-M or M-1/1-1)
     *
     * @return void
     */
    public function addToParent($recId=null)
    {
        $rec = $this->getActiveRecord($recId);

        /* @var $parentForm EasyForm */
        $parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);

        //clear parent form search rules
        $this->m_SearchRule="";
        $parentForm->getDataObj()->clearSearchRule();
        
        // add record to parent form's dataObj who is M-M or M-1/1-1 to its parent dataobj
        $ok = $parentForm->getDataObj()->addRecord($rec, $bPrtObjUpdated);
        if (!$ok)
            return $parentForm->processDataObjError($ok);
        
        
        $this->close();

        $parentForm->rerender();

        // just keep it simple, don't refresh parent's parent form :)
    }


    /**
     * Parse Picker Map into an array
     *
     * @param string $pickerMap pickerMap defined in metadata
     * @return array picker map array
     */
    private function _parsePickerMap($pickerMap)
    {
        $returnList = array();
        $pickerList = explode(",", $pickerMap);
        foreach ($pickerList as $pair)
        {
            $controlMap = explode(":", $pair);
            $controlMap[0] = trim($controlMap[0]);
            $controlMap[1] = trim($controlMap[1]);
            $returnList[] = $controlMap;
        }
        return $returnList;
    }
}
?>