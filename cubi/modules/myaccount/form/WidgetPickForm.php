<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.myaccount.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class WidgetPickForm extends PickerForm
{
	public function PicktoParent()
	{
	 	if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
                    
        foreach ($selIds as $id)
        {
            $rec = $this->getDataObj()->fetchById($id);           
			$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
			$parentDo = $parentForm->getDataObj();
			$user_id = BizSystem::getUserProfile("Id");
			
			$newRec = array(
				"user_id" => $user_id,
				"widget" => $rec['name'],
				"ordering" => 10,
				"status" => 1
			);
			$parentDo->insertRecord($newRec);
        }
        
		
		
		$this->close();
        $parentForm->rerender();
	}
}
?>