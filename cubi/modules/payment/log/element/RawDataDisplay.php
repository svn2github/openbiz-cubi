<?php
require_once OPENBIZ_BIN.'/easy/element/LabelText.php';
 
class RawDataDisplay extends LabelText
{
	public function render()
	{
		$value = $this->getValue();
		$dataGrid = unserialize($value);
		if(isset($dataGrid['custom']))
		{
			$customArr = unserialize($dataGrid['custom']);
			unset($dataGrid['custom']);
		}
		$html="<table  class=\"rawdata_display\" border=\"0\" cellspacing=\"0\">";
		foreach ($dataGrid as $key=>$value)
		{
			$html.="<tr>";
			$html.="<td class=\"label\">$key</td>";
			$html.="<td class=\"value\">$value</td>";
			$html.="</tr>";
		}
		if(is_array($customArr)){
			foreach ($customArr as $key=>$value)
			{
				$html.="<tr>";
				$html.="<td class=\"label\">$key</td>";
				$html.="<td class=\"value\">$value</td>";
				$html.="</tr>";
			}
		}
		$html.="<table>";
		return $html;
	}
}
?>