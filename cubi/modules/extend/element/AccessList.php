<?php 
class AccessList extends Listbox
{
	public function getSelectFrom(){
		$formname = $this->getFormObj()->m_ParentFormName;
		if(!$formname)
		{
			$formname = "extend.widget.ExtendSettingEditForm";
		}				
		return BizSystem::getObject($formname)
					->m_ParentFormElementMeta['ATTRIBUTES']['ACCESSSELECTFROM'];
	}
}
?>