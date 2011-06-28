<?php
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