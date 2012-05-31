<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.extend.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once dirname(__FILE__).'/ExtendDataEditForm.php';
class ExtendDataDetailForm extends ExtendDataEditForm
{
	public function configElemArr($elemArr)
	{
		switch($elemArr['ATTRIBUTES']['CLASS'])
		{
			case "InputText":
			case "InputDate":
			case "InputDatetime":
				$elemArr['ATTRIBUTES']['CLASS']="LabelText";
				break;
			case "Textarea":
				$elemArr['ATTRIBUTES']['CLASS']="LabelTextarea";
				break;
			case "DropDownList":
			case "Listbox":
				$elemArr['ATTRIBUTES']['CLASS']="LabelList";
				break;
			case "LabelBool":
				$elemArr['ATTRIBUTES']['CLASS']="LabelBool";
				break;
		}
		return $elemArr;
	}	
}
?>