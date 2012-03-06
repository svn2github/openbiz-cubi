<?php 
class AccessLabel extends LabelList
{
	public function getSelectFrom(){
		$formname = $this->getFormObj()->m_ParentFormName;
		if(!$formname)
		{
			$formname = "extend.widget.ExtendSettingListEditForm";
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