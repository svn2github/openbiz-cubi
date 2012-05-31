<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class currencyService 
{
	public function getName($currency_code,$type='full')
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale($current_locale);
		require_once('Zend/Currency.php');
		
		$current_currency = DEFAULT_CURRENCY;		
		if(!$current_currency){
			$current_currency = "USD";
		}
		
		$currency = new Zend_Currency($current_currency,$current_locale);
		
		$display_name = $currency->getName($currency_code,$current_locale);
		switch ($type){
			case "full":
				$display_name = "$currency_code - $display_name";
				break;
		}
		
		return $display_name;
	}
	
	public function getDefaultCurrency()
	{
		$display_name = $this->getName(DEFAULT_CURRENCY,'short');
		return $display_name;
	}	

	public function getDefaultCurrencySymbol()
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Currency.php');
		$current_currency = DEFAULT_CURRENCY;		
		if(!$current_currency){
			$current_currency = "USD";
		}
		
		$currency = new Zend_Currency($current_currency,$current_locale);
		$currency->getSymbol($current_currency,$current_locale);
		return $display_name;
	}	
	
	public function getFormatCurrency($amount)
	{
		$current_locale = I18n::getCurrentLangCode();		
		require_once('Zend/Currency.php');
		$current_currency = DEFAULT_CURRENCY;		
		if(!$current_currency){
			$current_currency = "USD";
		}
		$currency = new Zend_Currency($current_currency,$current_locale);	
		$amount = floatval($amount);
	
		$display_name = $currency->toCurrency($amount);
		return $display_name;
	}	
}
?>