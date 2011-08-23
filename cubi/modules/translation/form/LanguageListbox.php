<?php 
require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class LanguageListbox extends EditCombobox{
	public function getFromList(&$list)
    {    	
   	    $current_locale = I18n::getCurrentLangCode();
    	
    	$country = BizSystem::clientProxy()->getFormInputs("fld_region");    	
    	$country = strtoupper($country);  
    	if(!$country){    		
    		$locale = explode('_', $current_locale);
    		$country = strtoupper($locale[0]);
    	}  	
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		$code2name = $locale->getTranslationList('territorytolanguage',$locale);
		$list = array();
		$i=0;
		foreach($code2name as $key => $value){	
			
			if(preg_match('/'.$country.'/',$value) || strtoupper($key)==$country){				
				$lang_list = explode(" ",$value);				
				foreach($lang_list as $lang){
					$list[$i]['txt'] = strtolower($key)."_".strtoupper($lang);
					$list[$i]['val'] = strtolower($key)."_".strtoupper($lang);
					$i++;
				}
			}
		}
		return $list;
    }
}
?>