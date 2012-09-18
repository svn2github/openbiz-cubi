<?php 
include_once(OPENBIZ_BIN.'/easy/element/Radio.php');

class ProviderSelector extends Radio
{
	public function getFromList(&$list, $selectFrom=null)
	{
		parent::getFromList($list, $selectFrom);
		foreach($list as $key=>$value)
		{
			$value['pic'] = RESOURCE_URL.'/payment/images/icon_'.$value['pic'].'.png'; 
			$list[$key] = $value;
		}
	}
	
}
?>