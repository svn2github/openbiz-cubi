<?php 
class localeService 
{
	public function getDefaultLangName($lang)
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		$display_name = Zend_Locale::getTranslation($lang,'language',$locale);
		if($display_name)
		{
			return $display_name;
		}
		else{		
			return $lang;
		}
	}
}
?>