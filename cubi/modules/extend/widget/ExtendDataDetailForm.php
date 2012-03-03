<?php 
include_once dirname(__FILE__).'/ExtendDataEditForm.php';
class ExtendDataDetailForm extends ExtendDataEditForm
{
	public function configElemArr($elemArr)
	{
		switch($elemArr['ATTRIBUTES']['CLASS'])
		{
			case "InputText":
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