<?php 
require_once(OPENBIZ_BIN."easy/element/DropDownList.php");
class LanguageSelector extends DropDownList{
    function getList(){
    	$list=array();
   		$lang_dir = APP_HOME.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;						
		if(!is_dir($lang_dir))
		{
			return 	array();
		}
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		$code2name = $locale->getTranslationList('language',$locale);
    	foreach (glob($lang_dir.DIRECTORY_SEPARATOR."*") as $dir){
    		$lang_code = basename($dir);
    		if($lang_code=='dictionary'){
    		 continue;
    		}
    		$locale = explode('_', $lang_code);
    		$lang_name = $code2name[strtolower($locale[0])];
    		array_push($list,array("val"=>$lang_code,
    								"txt"=>$lang_name." ( $lang_code )",
    								"pic"=>APP_URL."/images/nations/22x14/".strtolower($locale[1]).".png"));
    		
    	}
    	return $list;
    }
}
?>