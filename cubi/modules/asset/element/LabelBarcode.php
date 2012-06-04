<?php
require_once OPENBIZ_BIN.'/easy/element/LabelText.php'; 
class LabelBarcode extends LabelText
{
	public function render()
	{
		$result = $this->m_Value;
		return $result;
	}
}
?>