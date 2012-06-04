<?php
require_once OPENBIZ_BIN.'/easy/element/ColumnText.php'; 
class ColumnBarcode extends ColumnText
{
	protected $m_Scale;
	
	protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_Scale = isset($xmlArr["ATTRIBUTES"]["SCALE"]) ? $xmlArr["ATTRIBUTES"]["SCALE"] : null;            
    }
    
	public function render()
	{
		$code = $this->m_Value;
		$code = substr($code,0,13);
		if($this->m_Height)
		{
			$height = $this->m_Height;
		}
		else
		{
			$height = 30;
		}
		if($this->m_Width)
		{
			$width = " width=\"".$this->m_Width."\" ";
		}
		else
		{
			$width = "";
		}
		if($this->m_Scale)
		{
			$scale = $this->m_Scale;
		}
		else
		{
			$scale = 1;	
		}
		$html = "<img $width src=\"".APP_URL."/modules/asset/lib/barcode/barcode.php?code=$code&encoding=EAN&scale=$scale&height=$height\" /> ";
		return $html;
	}
}
?>