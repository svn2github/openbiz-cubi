<?php 
class AssetForm extends EasyForm
{
	public function GetDefaultBarCode()
	{
		$code = rand(1000000000000,9999999999999);
		return $code;
	}
}
?>