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
    protected function translateList(&$list, $tag)
    {	
		$package = $this->getSelectFrom();		
    	I18n::AddLangData(substr($package,0,intval(strpos($package,'.'))),"extend");
    	parent::translateList($list, $tag);
    }
}
?>