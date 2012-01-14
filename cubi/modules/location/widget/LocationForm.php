<?php 
class LocationForm extends EasyForm
{
	
	public function close(){
		$parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}

}
?>