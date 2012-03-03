<?php 
class AccessList extends Listbox
{
	public function getSelectFrom(){
		return BizSystem::getObject($this->getFormObj()->m_ParentFormName)
					->m_ParentFormElementMeta['ATTRIBUTES']['ACCESSSELECTFROM'];
	}
}
?>