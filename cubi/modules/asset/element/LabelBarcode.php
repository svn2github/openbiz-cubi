<?php
require_once OPENBIZ_BIN.'/easy/element/LabelText.php'; 
class LabelBarcode extends LabelText
{
	public function render()
	{
		$code = $this->m_Value;
		$code = substr($code,0,13);
		$html = "<img src=\"".APP_URL."/modules/asset/lib/barcode/barcode.php?code=$code&encoding=EAN\" /> ";
		return $html;
	}
}
?>