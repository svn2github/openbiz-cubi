<?php 
require_once(OPENBIZ_BIN."easy/element/DropDownList.php");
class CurrencySelector extends Listbox{
    function getFromList(&$list){

		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
			
		$current_currency = DEFAULT_CURRENCY;		
		if(!$current_currency){
			$current_currency = "USD";
		}
		require_once('Zend/Currency.php');
		
		$currency = new Zend_Currency($current_currency,$current_locale);
		$currencyList = $currency->getCurrencyList();
    	foreach ($currencyList as $currency_code => $country){
    		
    				$display_name = $currency->getName($currency_code,$current_locale);
    				if($display_name){    					
			    		array_push($list,array("val"=>$currency_code,
			    								"txt"=>"$currency_code - $display_name"
			    		));
    				}
    		
    	}
    	return $list;
    }
}
?>