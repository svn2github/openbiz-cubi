<?php 
class BarcodeGenForm extends EasyForm
{
	public function fetchDataSet()
	{
		$result = array();
		for($i=0;$i<$this->m_Range;$i++)
		{
			$code = rand(1000000000000,9999999999999);
			$record = array(
				"Id"=>$code,
				"barcode"=>$code
			);
			$result[] = $record;
			
		}
		return $result;
	}
}
?>