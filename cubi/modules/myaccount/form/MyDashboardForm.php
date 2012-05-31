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

class MyDashboardForm extends EasyForm
{
	public function ConfigWidget($id=null){
		if(!$id)
		{
			if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
		}
		$dataRec = $this->getDataObj()->fetchById($id);
		$widget = $dataRec['widget'];
		
		$widgetObj = BizSystem::GetObject($widget);
		if($widgetObj->configable)
		{
			$configForm = $widgetObj->configForm;
			$this->switchForm($configForm);	
		}		
	}
	
}
?>