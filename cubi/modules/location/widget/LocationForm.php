<?php 
class LocationForm extends EasyForm
{
	
	public function close(){
		$parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}
	
	public function outputAttrs()
	{
		$result = parent::outputAttrs();
		$result['js_name'] = str_replace(".", "_", $result['name']);		
		$result['js_name'] = md5($result['js_name']);
		if( BizSystem::getObject($this->m_ParentFormName)->m_RecordId ){
			$result['js_name'] .= '_'.BizSystem::getObject($this->m_ParentFormName)->m_RecordId;
		} 
		$result['rand'] = md5(rand());	
		return $result;
	}

}
?>