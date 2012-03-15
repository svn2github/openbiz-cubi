<?php 
class localeService 
{
	public function getDefaultLangName()
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		$display_name = Zend_Locale::getTranslation(DEFAULT_LANGUAGE,'language',$current_locale);		
		return $display_name;
	}
}
?>