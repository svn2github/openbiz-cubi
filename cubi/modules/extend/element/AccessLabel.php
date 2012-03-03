<?php 
class AccessLabel extends LabelList
{
	public function getSelectFrom(){
		return BizSystem::getObject($this->getFormObj()->m_ParentFormName)
					->m_ParentFormElementMeta['ATTRIBUTES']['ACCESSSELECTFROM'];
	}
}
?>