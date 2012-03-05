<?php 
class ExtendFieldService
{
	protected $m_ExtendSettingTranslationDO = "extend.do.ExtendSettingTranslationDO";
	protected $m_ExtendSettingOptionDO 		= "extend.do.ExtendSettingOptionDO";
		
	
	public function translateElemArr($elemArr,$setting_id)
	{
		$lang = I18n::getCurrentLangCode();

		if(!$lang){
			return $elemArr;
		}
		$setting_id = (int)$setting_id;
		
		$transDO = BizSystem::getObject($this->m_ExtendSettingTranslationDO,1);
		$transRec = $transDO->fetchOne("[setting_id]='$setting_id' AND [lang]='$lang'");
		if(!$transRec)
		{
			return $elemArr;
		}
		$elemArr['LABEL']		 = $transRec['label'];
		$elemArr['DESCRIPTION']	 = $transRec['description'];
		$elemArr['DEFAULTVALUE'] = $transRec['defaultvalue'];
		if($elemArr['SELECTFROM'])
		{
			$transOptDO = BizSystem::getObject($this->m_ExtendSettingOptionDO,1);
			$opts = $transOptDO->directfetch("[setting_id]='".$setting_id."' AND [lang]='$lang'");			
			if($opts && $opts->count()>0){
				$elemArr['SELECTFROM'] = $this->m_ExtendSettingOptionDO."[text:value],[setting_id]='".$setting_id."' AND [lang]='$lang' ";				
			}
		}
		return $elemArr;		
	}
}
?>