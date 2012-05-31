<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.translation.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class RegionListbox extends Listbox{
	public function getFromList(&$list)
    {    	
		require_once('Zend/Locale.php');
		$locale = new Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('territory',$locale,2);
		$list = array();
		$i=0;
		foreach ($code2name as $key => $value){	
			if((int)$key==0){
				$list[$i]['val'] = $key;
	            $list[$i]['txt'] = $value;
	            $i++;  		
			}	
			
		}
		return $list;
    }
}
?>