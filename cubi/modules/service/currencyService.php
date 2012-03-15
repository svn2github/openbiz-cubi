<?php 
class currencyService 
{
	public function getName($currency_code,$type='short')
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		require_once('Zend/Currency.php');
		
		$current_currency = DEFAULT_CURRENCY;		
		if($current_currency){
			$current_currency = "USD";
		}
		
		$currency = new Zend_Currency($current_currency,$current_locale);
		
		$display_name = $currency->getName($currency_code,$current_locale);
		switch ($type){
			case "short":
				$display_name = "$currency_code - $display_name";
				break;
		}
		
		return $display_name;
	}
}
?>