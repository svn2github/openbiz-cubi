<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.contact.view
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class ContactListView extends EasyView
{
	protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        unset($this->m_FormRefs);
        $formRefXML = $this->getDefaultMainForm($xmlArr["EASYVIEW"]["FORMREFERENCES"]["REFERENCE"]);
        $this->m_FormRefs = new MetaIterator($formRefXML,"FormReference",$this);
    }
    
    public function getDefaultMainForm(&$xmlArr)
    {
        $formObj=BizSystem::GetObject("contact.widget.ViewSelectorLeftWidget");
        $targetForm = $formObj->getViewMode();
        $newForm = array(
			"ATTRIBUTES"=>array(
				"NAME"=>$targetForm
				),
			"VALUE"=>null
		);
		$newArr = array($xmlArr,$newForm);
		return $newArr;
    }
}